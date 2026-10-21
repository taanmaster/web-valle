<?php

namespace App\Livewire\ProteccionCivil\Cases;

use App\Models\CivilProtectionCase;
use App\Models\CivilProtectionCaseDocument;
use App\Models\CivilProtectionProcedure;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Session;

class Create extends Component
{
    use WithFileUploads;

    public $procedureId = '';

    public $person_type = 'fisica';

    public $applicant_name = '';

    public $phone = '';

    public $email = '';

    /**
     * Archivos recibidos en ventanilla, indexados por id de requisito
     */
    public $files = [];

    public function updatedProcedureId()
    {
        $this->files = [];
        $this->resetValidation();
    }

    public function save()
    {
        $procedure = CivilProtectionProcedure::with('requirements')->find($this->procedureId);

        $rules = [
            'procedureId' => 'required|exists:civil_protection_procedures,id',
            'person_type' => 'required|in:fisica,moral',
            'applicant_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'nullable|email|max:255',
        ];

        $attributes = [
            'procedureId' => 'trámite',
            'applicant_name' => $this->person_type === 'moral' ? 'razón social' : 'nombre completo',
            'phone' => 'teléfono',
        ];

        foreach ($procedure?->requirements ?? [] as $requirement) {
            $mimes = collect($requirement->formats)->map(fn ($f) => $f === 'jpg' ? 'jpg,jpeg' : $f)->implode(',');
            $rules['files.'.$requirement->id] = 'nullable|file|max:20480|mimes:'.$mimes;
            $attributes['files.'.$requirement->id] = $requirement->name;
        }

        $this->validate($rules, [], $attributes);

        $case = DB::transaction(function () use ($procedure) {
            $case = CivilProtectionCase::create([
                'folio' => CivilProtectionCase::nextFolio(),
                'civil_protection_procedure_id' => $procedure->id,
                'user_id' => $this->email ? User::role('citizen')->where('email', $this->email)->value('id') : null,
                'created_by' => Auth::id(),
                'origin' => 'presencial',
                'person_type' => $this->person_type,
                'applicant_name' => $this->applicant_name,
                'phone' => $this->phone,
                'email' => $this->email ?: null,
                'status' => 'en_revision',
                'submitted_at' => now(),
            ]);

            foreach ($procedure->requirements as $requirement) {
                $document = $case->documents()->create(CivilProtectionCaseDocument::attributesFromRequirement($requirement));

                if ($file = $this->files[$requirement->id] ?? null) {
                    $document->addVersion($file, Auth::id());
                }
            }

            $case->log('en_revision', 'Carpeta creada en ventanilla.', Auth::id());

            return $case;
        });

        Session::flash('success', 'Carpeta creada con el folio '.$case->folio.'.');

        return redirect()->route('proteccion_civil.cases.show', $case);
    }

    public function render()
    {
        return view('livewire.proteccion-civil.cases.create', [
            'procedures' => CivilProtectionProcedure::orderBy('name')->get(['id', 'name']),
            'requirements' => $this->procedureId
                ? CivilProtectionProcedure::find($this->procedureId)?->requirements ?? collect()
                : collect(),
            'nextFolio' => CivilProtectionCase::nextFolio(),
        ]);
    }
}
