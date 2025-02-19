<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransparencyDependency;
use Illuminate\Support\Str;

class DependencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dependencies = [
            'Secretaría del Ayuntamiento',
            'Fiscalización y control',
            'Protección civil',
            'Tesorería',
            'Catastro e impuesto predial',
            'Casa de la cultura',
            'Comisión municipal y gimnasio',
            'Panteones',
            'Mercado municipal',
            'Rastro municipal',
            'Servicio de limpia',
            'Alumbrado público',
            'Parques y Jardines',
            'Movilidad y transporte',
            'Padrones municipales',
            'Licitaciones y proveeduría',
            'DIF municipal',
        ];

        foreach ($dependencies as $dependency) {
            TransparencyDependency::create([
                'name' => $dependency,
                'slug' => Str::slug($dependency),
                'description' => null,
                'logo' => null,
                'image_cover' => null,
                'in_index' => false,
            ]);
        }
    }
}