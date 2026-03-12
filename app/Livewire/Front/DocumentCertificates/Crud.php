<?php

namespace App\Livewire\Front\DocumentCertificates;

use Livewire\Component;
use App\Models\DocumentCertificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Crud extends Component
{
    public $certificate;
    public $mode = 0; // 0: create, 1: show

    // Datos del solicitante
    public $full_name = '';
    public $address = '';
    public $email = '';
    public $phone = '';

    // Datos del documento
    public $filename = '';
    public $request = '';
    public $request_intent = '';

    public function mount()
    {
        if ($this->certificate) {
            $this->mode = 1;
            $this->fetchCertificateData();
        } else {
            $this->email = Auth::user()->email ?? '';
            $this->full_name = Auth::user()->name ?? '';
        }
    }

    public function fetchCertificateData()
    {
        $this->full_name      = $this->certificate->full_name;
        $this->address        = $this->certificate->address;
        $this->email          = $this->certificate->email;
        $this->phone          = $this->certificate->phone;
        $this->filename       = $this->certificate->filename;
        $this->request        = $this->certificate->request;
        $this->request_intent = $this->certificate->request_intent;
    }

    public function save()
    {
        $this->validate([
            'full_name'      => 'required|string|max:255',
            'address'        => 'required|string',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:15',
            'filename'       => 'required|string|max:255',
            'request'        => 'required|string',
            'request_intent' => 'required|string',
        ], [
            'full_name.required'      => 'El nombre completo es obligatorio.',
            'address.required'        => 'El domicilio es obligatorio.',
            'filename.required'       => 'El nombre del documento es obligatorio.',
            'request.required'        => 'La solicitud es obligatoria.',
            'request_intent.required' => 'El interés legítimo es obligatorio.',
        ]);

        $folio = $this->generateFolio();

        $certificate = DocumentCertificate::create([
            'user_id'        => Auth::id(),
            'folio'          => $folio,
            'full_name'      => $this->full_name,
            'address'        => $this->address,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'filename'       => $this->filename,
            'request'        => $this->request,
            'request_intent' => $this->request_intent,
            'status'         => 'Solicitud nueva',
        ]);

        Session::flash('success', 'Tu solicitud ha sido enviada correctamente. Folio: ' . $folio);

        return redirect()->route('citizen.profile.document_certificates.show', $certificate->id);
    }

    protected function generateFolio()
    {
        $year = date('Y');
        $lastCertificate = DocumentCertificate::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastCertificate ? intval(substr($lastCertificate->folio, -4)) + 1 : 1;

        return 'CD' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        return view('front.user_profiles.citizen.document_certificates.utilities.crud');
    }
}
