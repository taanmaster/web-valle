<?php

namespace App\Livewire\TsrAccountsDue\Profiles;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

// Modelos
use App\Models\TransparencyDependency;
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TsrAccountDueProvisionalIntegerFolio;
use App\Models\TsrAccountDueProfile;

class IntegerModal extends Component
{
    // Dependencias de tesorería
    public $dependencies = [];

    //Perfil de cobro
    public $profile;

    //Entero
    public $integer;

    public $today;
    public $folio = '';

    // Tipo de entero
    public $integer_type = '';

    // Folios
    public $folios = [];
    public $new_folio = '';
    public $new_quantity = '';

    // Campos
    #[Validate('required')]
    public $account_due_profile_id = '';
    public $dependency_name = '';
    public $qty_text = '';
    public $qty_integer = '';
    public $name = '';
    public $address = '';
    public $zipcode = '';
    public $basis = '';
    public $concept = '';
    public $payment_method = '';
    public $payment_date = '';
    public $created_by = '';
    public $director = '';


    #[On('selectInteger')]
    public function showModal($id)
    {
        $this->integer = TsrAccountDueProvisionalInteger::find($id);

        $this->fetchIntegerData();
    }

    #[On('selectProfile')]
    public function showModalNew($id)
    {
        $this->profile = TsrAccountDueProfile::find($id);

        $this->resetForm();

        $this->mount();
    }

    public function mount()
    {
        // Cargar las dependencias de transparencia
        $this->dependencies = TransparencyDependency::where('belongs_to_treasury', true)->get();

        $this->today = Carbon::now()->format('Y-m-d');

        if ($this->integer != null) {
            $this->fetchIntegerData();
        }

        if ($this->profile != null) {
            // Si se pasa un perfil, cargar sus datos
            $this->account_due_profile_id = $this->profile->id;
            $this->name = $this->profile->name;
            $this->address = $this->profile->address;
            $this->zipcode = $this->profile->zipcode;
            $this->payment_date = $this->today;
        }
    }

    public function fetchIntegerData()
    {
        $this->folio = $this->integer->id;
        $this->account_due_profile_id = $this->integer->account_due_profile_id;
        $this->dependency_name = $this->integer->dependency_name;
        $this->qty_text = $this->integer->qty_text;
        $this->qty_integer = $this->integer->qty_integer;
        $this->name = $this->integer->name;
        $this->address = $this->integer->address;
        $this->zipcode = $this->integer->zipcode;
        $this->basis = $this->integer->basis;
        $this->concept = $this->integer->concept;
        $this->payment_method = $this->integer->payment_method;
        $this->director = $this->integer->director;
        $this->payment_date = $this->integer->created_at;
        $this->created_by = $this->integer->created_by;
        $this->payment_date = $this->integer->created_at->format('Y-m-d');

        // Cargar folios existentes
        $this->folios = $this->integer->folios->map(function ($folio) {
            return [
                'folio' => $folio->folio,
                'quantity' => $folio->quantity,
            ];
        })->toArray();

        // Cargar el tipo de entero desde la base de datos
        $this->integer_type = $this->integer->type ?? '';
    }

    public function updatedIntegerType($value)
    {
        // Si cambia a "aportaciones", limpiar los folios y resetear cantidades
        if ($value === 'aportaciones') {
            $this->folios = [];
            $this->new_folio = '';
            $this->new_quantity = '';
            $this->qty_integer = '';
            $this->qty_text = '';
        }
    }

    public function addFolio()
    {
        if (empty($this->new_folio) || empty($this->new_quantity)) {
            return;
        }

        $this->folios[] = [
            'folio' => $this->new_folio,
            'quantity' => (float) $this->new_quantity,
        ];

        $this->new_folio = '';
        $this->new_quantity = '';

        $this->calculateTotal();
    }

    public function removeFolio($index)
    {
        unset($this->folios[$index]);
        $this->folios = array_values($this->folios);

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->folios as $folio) {
            $total += (float) $folio['quantity'];
        }

        $this->qty_integer = $total;
        $this->qty_text = $this->numberToWords($total);
    }

    public function numberToWords($number)
    {
        $units = ['', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        $tens = ['', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        $teens = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
        $hundreds = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

        $number = round($number, 2);
        $intPart = (int) $number;
        $decPart = round(($number - $intPart) * 100);

        if ($intPart == 0) {
            $result = 'CERO';
        } else {
            $result = '';

            // Millones
            if ($intPart >= 1000000) {
                $millions = (int) ($intPart / 1000000);
                if ($millions == 1) {
                    $result .= 'UN MILLON ';
                } else {
                    $result .= $this->convertHundreds($millions, $units, $tens, $teens, $hundreds) . ' MILLONES ';
                }
                $intPart = $intPart % 1000000;
            }

            // Miles
            if ($intPart >= 1000) {
                $thousands = (int) ($intPart / 1000);
                if ($thousands == 1) {
                    $result .= 'MIL ';
                } else {
                    $result .= $this->convertHundreds($thousands, $units, $tens, $teens, $hundreds) . ' MIL ';
                }
                $intPart = $intPart % 1000;
            }

            // Cientos
            if ($intPart > 0) {
                if ($intPart == 100) {
                    $result .= 'CIEN';
                } else {
                    $result .= $this->convertHundreds($intPart, $units, $tens, $teens, $hundreds);
                }
            }
        }

        $result = trim($result);

        // Agregar centavos
        $result .= ' PESOS ' . str_pad($decPart, 2, '0', STR_PAD_LEFT) . '/100 M.N.';

        return $result;
    }

    private function convertHundreds($number, $units, $tens, $teens, $hundreds)
    {
        $result = '';

        if ($number >= 100) {
            if ($number == 100) {
                return 'CIEN';
            }
            $result .= $hundreds[(int) ($number / 100)] . ' ';
            $number = $number % 100;
        }

        if ($number >= 20) {
            $ten = (int) ($number / 10);
            $unit = $number % 10;
            if ($unit == 0) {
                $result .= $tens[$ten];
            } else {
                $result .= $tens[$ten] . ' Y ' . $units[$unit];
            }
        } elseif ($number >= 10) {
            $result .= $teens[$number - 10];
        } elseif ($number > 0) {
            $result .= $units[$number];
        }

        return trim($result);
    }

    public function save()
    {
        $this->validate();

        // Crear un nuevo registro de TsrAccountDueProvisionalInteger
        $provisionalInteger = TsrAccountDueProvisionalInteger::create([
            'account_due_profile_id' => $this->account_due_profile_id,
            'dependency_name' => $this->dependency_name,
            'qty_text' => $this->qty_text,
            'qty_integer' => $this->qty_integer,
            'name' => $this->name,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'basis' => $this->basis,
            'concept' => $this->concept,
            'payment_method' => $this->payment_method,
            'created_by' => $this->created_by,
            'director' => $this->director,
            'type' => $this->integer_type,
        ]);

        // Guardar los folios si el tipo es recaudación
        if ($this->integer_type === 'recaudacion' && count($this->folios) > 0) {
            foreach ($this->folios as $folio) {
                TsrAccountDueProvisionalIntegerFolio::create([
                    'provisional_integer_id' => $provisionalInteger->id,
                    'folio' => $folio['folio'],
                    'quantity' => $folio['quantity'],
                ]);
            }
        }

        // Reiniciar el formulario
        $this->resetForm();

        // Mensaje de sesión
        Session::flash('success', 'Entero creado correctamente.');

        // Mensaje de sesión
        return redirect()->route('account_due_profiles.show', $this->profile->id);
    }

    public function resetForm()
    {
        $this->account_due_profile_id = '';
        $this->dependency_name = '';
        $this->qty_text = '';
        $this->qty_integer = '';
        $this->name = '';
        $this->address = '';
        $this->zipcode = '';
        $this->basis = '';
        $this->concept = '';
        $this->payment_method = '';
        $this->payment_date = '';
        $this->created_by = '';
        $this->director = '';

        // Reiniciar el tipo de entero y folios
        $this->integer_type = '';
        $this->folios = [];
        $this->new_folio = '';
        $this->new_quantity = '';

        // Reiniciar el entero
        $this->integer = null;
    }

    public function render()
    {
        return view('tsr_accounts_due.profiles.utilities.integer-modal');
    }
}
