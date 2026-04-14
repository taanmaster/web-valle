<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BillableService;

class BillableServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'       => 'Constancia de Residencia',
                'unit_price' => 87.05,
                'is_active'  => true,
            ],
            [
                'name'       => 'Constancia de Origen e Identidad',
                'unit_price' => 87.05,
                'is_active'  => true,
            ],
        ];

        foreach ($services as $service) {
            BillableService::firstOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
