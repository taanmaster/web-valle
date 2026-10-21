<?php

namespace App\Livewire\Citizen\CivilProtection;

use App\Models\CivilProtectionCase;
use App\Models\CivilProtectionCaseDocument;
use App\Models\CivilProtectionProcedure;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Session;

/**
 * Solicitud en línea de un trámite de Protección Civil (borrador → enviada)
 */
class RequestForm extends Component
{
    use WithFileUploads;

    public CivilProtectionProcedure $procedure;

    public ?CivilProtectionCase $case = null;

    public $person_type = 'fisica';

    public $applicant_name = '';

    public $phone = '';

    public $email = '';

    /** Archivos por id de requisito del trámite */
    public $uploads = [];

    public $confirmingSubmit = false;

    public function mount(CivilProtectionProcedure $procedure, ?CivilProtectionCase $case = null)
    {
        $this->procedure = $procedure;
        $user = Auth::user();

        if ($case?->exists) {
            abort_unless($case->user_id === $user->id && $case->status === 'borrador', 404);
            $this->case = $case;
            $this->fill($case->only(['person_type', 'applicant_name', 'phone', 'email']));
        } else {
            $this->applicant_name = $user->name;
            $this->email = $user->email;
        }
    }

    /**
     * Crea el borrador la primera vez que hay algo que guardar
     */
    private function ensureDraft(): CivilProtectionCase
    {
        if ($this->case) {
            $this->case->update($this->applicantData());

            return $this->case;
        }

        $this->case = DB::transaction(function () {
            $case = CivilProtectionCase::create($this->applicantData() + [
                'civil_protection_procedure_id' => $this->procedure->id,
                'user_id' => Auth::id(),
                'origin' => 'online',
                'status' => 'borrador',
            ]);

            foreach ($this->procedure->requirements as $requirement) {
                $case->documents()->create(CivilProtectionCaseDocument::attributesFromRequirement($requirement));
            }

            return $case;
        });

        // La URL pasa a ser la del borrador para poder retomarlo
        $this->js("history.replaceState(null, '', '".route('citizen.civil_protection.edit', $this->case)."')");

        return $this->case;
    }

    private function applicantData(): array
    {
        return [
            'person_type' => $this->person_type,
            'applicant_name' => $this->applicant_name ?: Auth::user()->name,
            'phone' => $this->phone ?? '',
            'email' => $this->email ?: null,
        ];
    }

    public function updatedUploads($file, $requirementId)
    {
        $requirement = $this->procedure->requirements->firstWhere('id', (int) $requirementId);
        abort_unless($requirement, 404);

        $mimes = collect($requirement->formats)->map(fn ($f) => $f === 'jpg' ? 'jpg,jpeg' : $f)->implode(',');
        $this->validate(['uploads.'.$requirementId => 'file|max:20480|mimes:'.$mimes], [], ['uploads.'.$requirementId => $requirement->name]);

        $case = $this->ensureDraft();
        $case->documents()->where('civil_protection_procedure_requirement_id', $requirement->id)->firstOrFail()
            ->addVersion($file, Auth::id(), true);

        unset($this->uploads[$requirementId]);
    }

    public function saveDraft()
    {
        $this->validate(['phone' => 'nullable|digits:10', 'email' => 'nullable|email']);
        $this->ensureDraft();

        Session::flash('success', 'Guardamos tu avance. Puedes continuar tu solicitud desde «Mis trámites».');

        return redirect()->route('citizen.civil_protection.index');
    }

    public function askSubmit()
    {
        $this->validateApplicant();

        if ($this->missingRequired() > 0) {
            $this->addError('documents', 'Sube todos los documentos obligatorios.');

            return;
        }

        $this->confirmingSubmit = true;
    }

    public function submit()
    {
        $this->validateApplicant();
        abort_if($this->missingRequired() > 0, 422);

        $case = $this->ensureDraft();
        $case->update([
            'folio' => CivilProtectionCase::nextFolio(),
            'status' => 'en_revision',
            'submitted_at' => now(),
        ]);
        $case->log('en_revision', 'Solicitud enviada en línea por el ciudadano.');

        return redirect()->route('citizen.civil_protection.show', $case);
    }

    private function validateApplicant(): void
    {
        $this->validate([
            'person_type' => 'required|in:fisica,moral',
            'applicant_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'nullable|email|max:255',
        ], [], [
            'applicant_name' => $this->person_type === 'moral' ? 'razón social' : 'nombre completo',
            'phone' => 'teléfono',
        ]);
    }

    private function missingRequired(): int
    {
        if (! $this->case) {
            return $this->procedure->requirements->where('is_required', true)->count();
        }

        return $this->case->documents()->where('is_required', true)->where('status', 'sin_entregar')->count();
    }

    public function render()
    {
        $documents = $this->case
            ? $this->case->documents()->with('latestVersion')->get()->keyBy('civil_protection_procedure_requirement_id')
            : collect();

        $required = $this->procedure->requirements->where('is_required', true)->count();

        return view('livewire.citizen.civil-protection.request-form', [
            'requirements' => $this->procedure->requirements,
            'documents' => $documents,
            'required' => $required,
            'missing' => $this->missingRequired(),
        ]);
    }
}
