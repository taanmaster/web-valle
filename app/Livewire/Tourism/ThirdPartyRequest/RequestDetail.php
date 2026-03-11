<?php

namespace App\Livewire\Tourism\ThirdPartyRequest;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

use App\Models\TourismThirdPartyRequest;
use App\Models\TourismThirdPartyObservation;
use App\Models\TourismThirdPartyEvidence;

class RequestDetail extends Component
{
    use WithFileUploads;

    public TourismThirdPartyRequest $request;
    public string $mode = 'citizen';

    // Admin: estatus
    public string $status = '';

    // Admin: observaciones
    public string $observation = '';
    public bool $showObsForm = false;

    // Tab activo
    public string $activeTab = 'detail';

    // Evidencia
    public bool $showEvidenceForm = false;
    public string $evidenceName = '';
    public $evidenceFile = null;

    public function mount(TourismThirdPartyRequest $request, string $mode = 'citizen')
    {
        $this->request = $request;
        $this->mode    = $mode;
        $this->status  = $request->status;
    }

    public function updateStatus()
    {
        $this->request->update(['status' => $this->status]);
        $this->request->refresh();
        session()->flash('status_updated', 'Estatus actualizado correctamente.');
    }

    public function saveObservation()
    {
        $this->validate(['observation' => 'required|min:5']);

        TourismThirdPartyObservation::create([
            'tourism_third_party_request_id' => $this->request->id,
            'user_id'     => Auth::id(),
            'observation' => $this->observation,
        ]);

        $this->observation = '';
        $this->showObsForm = false;
        $this->request->refresh();

        session()->flash('obs_saved', 'Observación agregada correctamente.');
    }

    public function saveEvidence()
    {
        $this->validate([
            'evidenceName' => 'required|max:200',
            'evidenceFile' => 'required|file|max:20480|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx',
        ], [
            'evidenceName.required' => 'El nombre es obligatorio.',
            'evidenceFile.required' => 'Debes seleccionar un archivo.',
            'evidenceFile.mimes'    => 'Solo se permiten imágenes, PDF, Word o Excel.',
            'evidenceFile.max'      => 'El archivo no puede pesar más de 20 MB.',
        ]);

        $extension = $this->evidenceFile->getClientOriginalExtension();
        $path = $this->evidenceFile->storeAs(
            "tourism/third_party_evidences/{$this->request->id}",
            time() . '_' . str()->slug($this->evidenceName) . '.' . $extension,
            's3'
        );

        TourismThirdPartyEvidence::create([
            'tourism_third_party_request_id' => $this->request->id,
            'uploaded_by'    => Auth::id(),
            'name'           => $this->evidenceName,
            'file_path'      => $path,
            'file_extension' => strtolower($extension),
        ]);

        $this->evidenceName      = '';
        $this->evidenceFile      = null;
        $this->showEvidenceForm  = false;
        $this->request->refresh();

        session()->flash('evidence_saved', 'Evidencia guardada correctamente.');
    }

    public function render()
    {
        $observations = TourismThirdPartyObservation::where('tourism_third_party_request_id', $this->request->id)
            ->with('user')->latest()->get();

        $evidences = TourismThirdPartyEvidence::where('tourism_third_party_request_id', $this->request->id)
            ->with('uploader')->latest()->get();

        return view('tourism.third_party_requests.utilities.request-detail', [
            'observations' => $observations,
            'evidences'    => $evidences,
        ]);
    }
}
