<?php

namespace App\Imports;

use App\Models\CTOProperty;
use App\Models\CTOPropertyTax;

use Str;
use Carbon\Carbon;

//Importación por medio de Colección
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CTOPropertyImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Extraer datos de la propiedad
            $taxpayer_type = $row['taxpayer_type'] ?? null;
            $taxpayer_name = $row['taxpayer_name'] ?? null;
            $taxpayer_phone = $row['taxpayer_phone'] ?? null;
            $street = $row['street'] ?? null;
            $street_num = $row['street_num'] ?? null;
            $int_num = $row['int_num'] ?? null;
            $suburb = $row['suburb'] ?? null;
            $cuota_type = $row['cuota_type'] ?? null;
            $location_account = $row['location_account'] ?? null;
            $location_type = $row['location_type'] ?? null;
            $location_num = $row['location_num'] ?? null;
            $location_note = $row['location_note'] ?? null;
            $location_origin = $row['location_origin'] ?? null;
            $location_surface = $row['location_surface'] ?? null;
            $location_use = $row['location_use'] ?? null;
            $location_law_value = $row['location_law_value'] ?? null;
            $location_surface_built = $row['location_surface_built'] ?? null;
            $location_condition = $row['location_condition'] ?? null;
            $last_appraisal = $row['last_appraisal'] ?? null;
            $payment_anual = $row['payment_anual'] ?? null;
            $payment_bimonthly = $row['payment_bimonthly'] ?? null;
            $tax_rate = $row['tax_rate'] ?? null;
            $total_payment = $row['total_payment'] ?? null;
            $issue_date = $row['issue_date'] ?? null;
            $validity_date = $row['validity_date'] ?? null;
            $payment_date = $row['payment_date'] ?? null;
            $bank_reference_json = $row['bank_reference_json'] ?? null;
            $notification_address = $row['notification_address'] ?? null;
            $notes = $row['notes'] ?? null;

            // Validar que al menos exista la cuenta catastral y el nombre del contribuyente
            if (!$location_account || !$taxpayer_name) {
                continue;
            }

            // Verificar si la propiedad ya existe
            $property = CTOProperty::where('location_account', $location_account)->first();
            
            // Si no existe, crear la propiedad
            if (empty($property)) {
                $property = CTOProperty::create([
                    'taxpayer_type' => $taxpayer_type,
                    'taxpayer_name' => $taxpayer_name,
                    'taxpayer_phone' => $taxpayer_phone,
                    'street' => $street,
                    'street_num' => $street_num,
                    'int_num' => $int_num,
                    'suburb' => $suburb,
                    'cuota_type' => $cuota_type,
                    'location_account' => $location_account,
                    'location_type' => $location_type,
                    'location_num' => $location_num,
                    'location_note' => $location_note,
                    'location_origin' => $location_origin,
                    'location_surface' => $location_surface,
                    'location_use' => $location_use,
                    'location_law_value' => $location_law_value,
                    'location_surface_built' => $location_surface_built,
                    'location_condition' => $location_condition,
                    'last_appraisal' => $last_appraisal,
                    'payment_anual' => $payment_anual,
                    'payment_bimonthly' => $payment_bimonthly,
                    'tax_rate' => $tax_rate,
                    'total_payment' => $total_payment,
                    'issue_date' => $issue_date ? Carbon::parse($issue_date) : null,
                    'validity_date' => $validity_date ? Carbon::parse($validity_date) : null,
                    'payment_date' => $payment_date ? Carbon::parse($payment_date) : null,
                    'bank_reference_json' => $bank_reference_json,
                    'notification_address' => $notification_address,
                    'notes' => $notes,
                ]);

                // Generar recibos automáticamente para años anteriores
                $years = [
                    2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010,
                    2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020,
                    2021, 2022, 2023, 2024, 2025
                ];

                foreach ($years as $year) {
                    $columnName = 'to_pay_' . $year;
                    $toPay = $row[$columnName] ?? null;

                    // Si hay un monto para este año
                    if ($toPay && $toPay > 0) {
                        // Determinar cuántos bimestres generar según el tipo de cuota
                        if ($cuota_type === 'cuota_minima' || $cuota_type === 'Cuota Minima') {
                            // Solo generar el primer bimestre
                            CTOPropertyTax::create([
                                'c_t_o_property_id' => $property->id,
                                'tax_year' => $year,
                                'bimonthly_period' => 1,
                                'cuota_type' => 'cuota_minima',
                                'payment_status' => 'pendiente',
                                'total_payment' => $toPay,
                                'folio' => $this->generateFolio($location_account, $year, 1),
                                'issue_date' => Carbon::create($year, 1, 1),
                                'due_date' => Carbon::create($year, 2, 28),
                                'payment_date' => null,
                                'discount_percentage' => 0,
                                'discount_amount' => 0,
                                'subtotal' => $toPay,
                                'surcharge_amount' => 0,
                            ]);
                        } else {
                            // Cuota Normal: dividir entre 6 bimestres
                            $bimonthlyAmount = round($toPay / 6, 2);
                            
                            for ($bimestre = 1; $bimestre <= 6; $bimestre++) {
                                // Calcular meses del bimestre
                                $startMonth = ($bimestre * 2) - 1;
                                $endMonth = $bimestre * 2;
                                
                                CTOPropertyTax::create([
                                    'c_t_o_property_id' => $property->id,
                                    'tax_year' => $year,
                                    'bimonthly_period' => $bimestre,
                                    'cuota_type' => 'cuota_normal',
                                    'payment_status' => 'pendiente',
                                    'total_payment' => $bimonthlyAmount,
                                    'folio' => $this->generateFolio($location_account, $year, $bimestre),
                                    'issue_date' => Carbon::create($year, $startMonth, 1),
                                    'due_date' => Carbon::create($year, $endMonth, 28),
                                    'payment_date' => null,
                                    'discount_percentage' => 0,
                                    'discount_amount' => 0,
                                    'subtotal' => $bimonthlyAmount,
                                    'surcharge_amount' => 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Generar folio único para el recibo
     */
    private function generateFolio($account, $year, $bimonthly)
    {
        return strtoupper($account . '-' . $year . '-B' . $bimonthly . '-' . Str::random(4));
    }

    public function headingRow(): int
    {
        return 1;
    }
}
