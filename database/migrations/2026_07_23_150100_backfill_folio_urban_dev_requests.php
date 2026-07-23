<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\UrbanDevRequest;

return new class extends Migration
{
    /**
     * Asigna folio a las solicitudes existentes que aún no lo tienen.
     */
    public function up(): void
    {
        UrbanDevRequest::whereNull('folio')->get()->each(function (UrbanDevRequest $request) {
            $request->folio = $request->buildFolio();
            $request->saveQuietly();
        });
    }

    public function down(): void
    {
        // Intencionalmente vacío.
    }
};
