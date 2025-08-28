<?php

namespace App\Imports;

use App\Models\Citizen;

use Str;
use Carbon\Carbon;

//Importación por medio de Colección
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitizenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $name = $row['name'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $phone = $row['phone'];
            $email = $row['email'];
            $curp = $row['curp'];
            $ine_number = $row['ine_number'];
            $ine_section = $row['ine_section'];
            $address = $row['address'];
            $street = $row['street'];
            $colony = $row['colony'];

            $citizen = Citizen::where('curp', $curp)->first();
            
            if (empty($citizen) && $name != NULL && $first_name != NULL && $last_name != NULL && $curp != NULL) {
                $data = Citizen::create([
                    'name' => $name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $phone ?? NULL,
                    'email' => $email ?? NULL,
                    'curp' => $curp,
                    'ine_number' => $ine_number,
                    'ine_section' => $ine_section,
                    'address' => $address,
                    'street' => $street,
                    'colony' => $colony,
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
