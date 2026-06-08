<?php

namespace App\Livewire\TsrAccountsDue\Profiles;

use Livewire\Component;

// Ayudantes
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

// Modelos
use App\Models\BackofficeDependency;
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
    public $backoffice_dependency_id = '';
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
    public $status = 'generado';


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
        // Cargar dependencias RH (backoffice)
        $this->dependencies = BackofficeDependency::orderBy('name')->get();

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
        $this->backoffice_dependency_id = $this->integer->backoffice_dependency_id;
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
        $this->status = $this->integer->status ?? 'generado';

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

    public function updatedBackofficeDependencyId($value)
    {
        if (empty($value)) {
            $this->dependency_name = '';
            return;
        }

        $dependency = BackofficeDependency::find($value);
        $this->dependency_name = $dependency?->name ?? '';
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
        $this->qty_text = $this->formatAmountToWords($total);
    }

    public function updatedQtyInteger($value)
    {
        if ($this->integer_type === 'recaudacion') {
            return;
        }

        if ($value === '' || $value === null) {
            $this->qty_text = '';
            return;
        }

        $this->qty_text = $this->formatAmountToWords((float) $value);
    }

    private function formatAmountToWords(float $totalAmt, string $currency = 'PESOS'): string
    {
        $enteros = (int) floor($totalAmt);
        $decimales = str_pad((int) round(($totalAmt - $enteros) * 100), 2, '0', STR_PAD_LEFT);

        return $this->numToWordsPDF($enteros) . ' ' . $currency . ' CON ' . $decimales . '/100';
    }

    private function numToWordsPDF(int $n): string
    {
        if ($n === 0) {
            return 'CERO';
        }

        $u = [
            '', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE',
            'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE',
            'DIECIOCHO', 'DIECINUEVE', 'VEINTE'
        ];
        $d = ['', '', 'VEINTI', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        $c = [
            '', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS',
            'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'
        ];

        if ($n <= 20) {
            return $u[$n];
        }

        if ($n === 100) {
            return 'CIEN';
        }

        if ($n < 100) {
            $dz = intdiv($n, 10);
            $un = $n % 10;

            if ($un === 0) {
                return $d[$dz];
            }

            return $dz === 2
                ? 'VEINTI' . strtolower($u[$un])
                : $d[$dz] . ' Y ' . $u[$un];
        }

        if ($n < 1000) {
            $cv = intdiv($n, 100);
            $r = $n % 100;
            return $r === 0 ? $c[$cv] : $c[$cv] . ' ' . $this->numToWordsPDF($r);
        }

        if ($n < 2000) {
            return 'MIL' . ($n % 1000 > 0 ? ' ' . $this->numToWordsPDF($n % 1000) : '');
        }

        if ($n < 1000000) {
            $m = intdiv($n, 1000);
            $r = $n % 1000;
            return $this->numToWordsPDF($m) . ' MIL' . ($r > 0 ? ' ' . $this->numToWordsPDF($r) : '');
        }

        if ($n < 2000000) {
            return 'UN MILLON' . ($n % 1000000 > 0 ? ' ' . $this->numToWordsPDF($n % 1000000) : '');
        }

        $m = intdiv($n, 1000000);
        $r = $n % 1000000;

        return $this->numToWordsPDF($m) . ' MILLONES' . ($r > 0 ? ' ' . $this->numToWordsPDF($r) : '');
    }

    public function save()
    {
        $this->validate();

        // Crear un nuevo registro de TsrAccountDueProvisionalInteger
        $provisionalInteger = TsrAccountDueProvisionalInteger::create([
            'account_due_profile_id' => $this->account_due_profile_id,
            'backoffice_dependency_id' => $this->backoffice_dependency_id,
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
            'status' => $this->status,
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
        $this->backoffice_dependency_id = '';
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
        $this->status = 'generado';

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
