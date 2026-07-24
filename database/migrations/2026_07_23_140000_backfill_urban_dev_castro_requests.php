<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\UrbanDevRequest;

return new class extends Migration
{
    /**
     * Genera el apartado de captura de Catastro para las solicitudes de
     * Permiso de Uso de Suelo / Permiso de Construcción que ya existían antes
     * de que se agregara la creación automática (booted() en UrbanDevRequest).
     */
    public function up(): void
    {
        UrbanDevRequest::whereIn('request_type', UrbanDevRequest::CASTRO_REQUEST_TYPES)
            ->whereDoesntHave('castro')
            ->get()
            ->each(function (UrbanDevRequest $request) {
                $request->castro()->create([
                    'status'          => 'pendiente',
                    'fecha_solicitud' => $request->created_at,
                    'cuenta_predial'  => $request->cuenta_predial,
                ]);
            });
    }

    /**
     * No se revierten los datos para evitar borrar capturas ya realizadas.
     */
    public function down(): void
    {
        // Intencionalmente vacío.
    }
};
