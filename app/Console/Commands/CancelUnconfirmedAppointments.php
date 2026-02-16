<?php

namespace App\Console\Commands;

use App\Models\AppointmentBooking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelUnconfirmedAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:cancel-unconfirmed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancela automáticamente las citas que no fueron confirmadas después de 24 horas.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cutoff = Carbon::now()->subHours(24);

        $bookings = AppointmentBooking::where('status', 'scheduled')
            ->where('created_at', '<', $cutoff)
            ->get();

        $count = $bookings->count();

        if ($count === 0) {
            $this->info('No hay citas pendientes de confirmación que cancelar.');
            return self::SUCCESS;
        }

        foreach ($bookings as $booking) {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }

        $this->info("Se cancelaron {$count} cita(s) no confirmada(s).");

        return self::SUCCESS;
    }
}
