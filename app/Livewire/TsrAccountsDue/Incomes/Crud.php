<?php

namespace App\Livewire\TsrAccountsDue\Incomes;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TsrRevenueLawRateAndFee;
use App\Models\TsrRevenueLawIncome;
use App\Models\TsrAdminRevenueColletionSection;
use App\Models\TsrRevenueLawConcept;
use App\Models\TsrAdminRevenueColletionVariant;
use Livewire\WithPagination;

class Crud extends Component
{

    use WithPagination;

    public $income;

    public $integer;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $showDrop = false;
    public $concept_type = '';


    //Costos y Tarifas
    public $rates;


    //Ley de Ingresos
    public $incomes;
    public $concepts;


    //Diposiciones
    public $sections;
    public $variants;

    public $section;
    public $article;
    public $fraction;
    public $clasue;
    public $variant;



    //Busquedas
    public $searchConcept = '';
    public $searchConceptLaw = '';
    public $searchAdmin = '';


    // Campos
    #[Validate('required')]
    public $department = '';
    #[Validate('required')]
    public $concept = '';
    #[Validate('required')]
    public $folio = '';
    public $provisional_integer_id = '';
    public $qty_text = '';
    public $qty_integer = '';
    public $name = '';
    public $type_of_person = ''; // Persona física o moral
    public $rfc_curp = '';
    public $address = '';
    public $zipcode = '';
    public $code = '';
    public $created_date = '';
    public $observations = '';
    public $work = '';
    public $locality = '';
    public $basis = '';

    public $today;


    public $searchFolio = '';

    public function mount()
    {
        $this->today = Carbon::now()->format('Y-m-d');

        $this->code = strtoupper(Str::random(10)); // Alfanumérico, 10 caracteres, en mayúsculas

        if ($this->income != null) {
            $this->fetchIncomeData();
        } else {
            $this->created_date = $this->today;
        }
    }


    public function fetchIncomeData()
    {
        $this->department = $this->income->department;
        $this->concept = $this->income->concept;
        $this->folio = $this->income->folio;
        $this->provisional_integer_id = $this->income->provisional_integer_id;
        $this->qty_text = $this->income->qty_text;
        $this->qty_integer = $this->income->qty_integer;
        $this->name = $this->income->name;
        $this->type_of_person = $this->income->type_of_person;
        $this->rfc_curp = $this->income->rfc_curp;
        $this->address = $this->income->address;
        $this->zipcode = $this->income->zipcode;
        $this->code = $this->income->code;
        $this->created_date = $this->income->created_date;
        $this->observations = $this->income->observations;
        $this->work = $this->income->work;
        $this->locality = $this->income->locality;
        $this->basis = $this->income->basis;
    }


    public function selectInteger($value)
    {
        $integer = TsrAccountDueProvisionalInteger::findOrFail($value);

        $this->folio = $integer->id;
        $this->provisional_integer_id = $integer->id;

        $this->department = $integer->dependency_name;

        $this->qty_text = $integer->qty_text;
        $this->qty_integer = $integer->qty_integer;

        $this->name = $integer->name;
        $this->type_of_person = $integer->profile->type_of_person;
        $this->rfc_curp = $integer->profile->rfc_curp;
        $this->address = $integer->address;
        $this->zipcode = $integer->zipcode;
        $this->basis = $integer->basis;

        $this->searchFolio = '';
        $this->concept = '';


        switch ($integer->basis) {
            case 'Otros':
                $this->concept_type = 'Costos';
                break;

            case 'Ley de Ingresos':
                $this->concept_type = 'Ley';
                break;

            case 'Disposiciones Administrativas':
                $this->concept_type = 'Disposiciones';
                break;
        }
    }

    public function updatedSearchConcept()
    {

        if ($this->concept_type === 'Ley') {
            $this->concepts = TsrRevenueLawConcept::when($this->searchConcept, function ($query) {
                $query->where('concept', 'like', '%' . $this->searchConcept . '%');
            })->get();
        }

        if ($this->concept_type === 'Disposiciones') {
            $this->variants = TsrAdminRevenueColletionVariant::when($this->searchConcept, function ($query) {
                $query->where('name', 'like', '%' . $this->searchConcept . '%');
            })->get();
        }

        if ($this->concept_type === 'Costos') {
            $this->rates = TsrRevenueLawRateAndFee::when($this->searchConcept, function ($query) {
                $query->where('section', 'like', '%' . $this->searchConcept . '%');
            })->get();
        }
    }

    public function selectConcept($concept)
    {
        $this->concept = $concept;

        $this->searchConcept = '';
    }

    public function save()
    {
        $this->validate();

        TsrAccountDueIncome::create([
            'department' => $this->department,
            'concept' => $this->concept,
            'folio' => $this->folio,
            'provisional_integer_id' => $this->provisional_integer_id,
            'qty_text' => $this->qty_text,
            'qty_integer' => $this->qty_integer,
            'name' => $this->name,
            'type_of_person' => $this->type_of_person,
            'rfc_curp' => $this->rfc_curp,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'code' => $this->code,
            'observations' => $this->observations,
            'work' => $this->work,
            'locality' => $this->locality,
            'basis' => $this->basis
        ]);

        // Crear el perfil
        $this->income = TsrAccountDueIncome::where('code', $this->code)->first();

        // Mensaje de sesión
        Session::flash('success', 'Ingreso creado correctamente.');


        // Mensaje de sesión
        return redirect()->route('account_due_incomes.show', $this->income->id);
    }

    public function render()
    {
        return view('tsr_accounts_due.incomes.utilities.crud');
    }
}
