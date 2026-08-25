<?php

namespace Tests\Feature\Payments;

use App\Models\Order;
use App\Models\User;
use App\Services\Payments\BanBajioMultipagos;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BanBajioNotificationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('banbajio_notifications');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('folio', 10)->unique();
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->string('payment_method');
            $table->string('payment_status')->default('Pago Pendiente');
            $table->string('delivery_status')->default('Pendiente');
            $table->string('payment_id')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_url', 500)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->timestamps();
        });
        Schema::create('banbajio_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('cl_folio')->nullable();
            $table->string('cl_referencia')->nullable();
            $table->string('cl_servicio')->nullable();
            $table->string('t_concepto')->nullable();
            $table->decimal('dl_monto', 10, 2)->nullable();
            $table->string('dt_fecha_pago')->nullable();
            $table->string('nl_tipo_pago', 2)->nullable();
            $table->string('nl_status', 2)->nullable();
            $table->text('hash');
            $table->boolean('hash_valid');
            $table->string('hash_variant')->nullable();
            $table->json('raw_payload');
            $table->string('response_sent');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function test_a_signed_collected_notification_marks_the_order_as_paid_and_is_idempotent(): void
    {
        config([
            'services.bajio.private_key_path' => 'keys/bajio/private_key.pem',
            'services.bajio.public_key_path' => 'keys/bajio/public_key_bajio.pem',
            'services.bajio.hash_probe' => false,
        ]);

        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'folio' => 'ABC1234567',
            'total' => '485.22',
            'payment_method' => 'banbajio',
            'payment_reference' => 'ABC1234567',
        ]);
        $payload = [
            'cl_folio' => (string) $order->id,
            't_concepto' => '1',
            'cl_referencia' => $order->payment_reference,
            'dl_monto' => '485.22',
            'dt_fechaPago' => '2026-08-25',
            'nl_tipoPago' => '02',
            'nl_status' => '01',
        ];
        $service = app(BanBajioMultipagos::class);
        $payload['hash'] = strtr($service->firmar($service->cadenaNotificacionCompleta($payload)), '+/=', '-_,');

        $this->post(route('webhook.bajio'), $payload)
            ->assertOk()
            ->assertSee('estatus_notificacion=0');
        $this->post(route('webhook.bajio'), $payload)
            ->assertOk()
            ->assertSee('estatus_notificacion=0');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_status' => 'Pagado',
            'paid_amount' => '485.22',
        ]);
        $this->assertDatabaseCount('banbajio_notifications', 2);
    }

    public function test_an_invalid_signature_is_rejected_without_changing_the_order(): void
    {
        config(['services.bajio.public_key_path' => 'keys/bajio/public_key_bajio.pem']);

        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'folio' => 'ABC1234567',
            'total' => '485.22',
            'payment_method' => 'banbajio',
            'payment_reference' => 'ABC1234567',
        ]);

        $this->post(route('webhook.bajio'), [
            'cl_folio' => (string) $order->id,
            'cl_referencia' => $order->payment_reference,
            'dl_monto' => '485.22',
            'nl_status' => '01',
            'hash' => 'firma-invalida',
        ])->assertOk()->assertSee('estatus_notificacion=1');

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'payment_status' => 'Pago Pendiente']);
        $this->assertDatabaseHas('banbajio_notifications', ['order_id' => $order->id, 'hash_valid' => false]);
    }
}