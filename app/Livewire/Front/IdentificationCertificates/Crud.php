<?php

namespace App\Livewire\Front\IdentificationCertificates;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\IdentificationCertificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Crud extends Component
{
    use WithFileUploads;

    public $certificate;
    public $mode = 0; // 0: create, 1: show

    // Datos del solicitante
    public $certificate_type = '';
    public $full_name = '';
    public $birth_date = '';
    public $curp = '';
    public $address = '';
    public $email = '';
    public $phone = '';

    // Archivos
    public $birth_certificate_file;
    public $proof_of_address_file;
    public $photo_file;

    // Primer testigo
    public $first_witness_full_name = '';
    public $first_witness_birth_date = '';
    public $first_witness_address = '';
    public $first_witness_ine_file;

    // Segundo testigo
    public $second_witness_full_name = '';
    public $second_witness_birth_date = '';
    public $second_witness_address = '';
    public $second_witness_ine_file;

    public function mount()
    {
        if ($this->certificate) {
            $this->mode = 1;
            $this->fetchCertificateData();
        } else {
            $this->email = Auth::user()->email;
        }
    }

    public function fetchCertificateData()
    {
        $this->certificate_type = $this->certificate->certificate_type;
        $this->full_name = $this->certificate->full_name;
        $this->birth_date = $this->certificate->birth_date ? \Carbon\Carbon::parse($this->certificate->birth_date)->format('Y-m-d') : '';
        $this->curp = $this->certificate->curp;
        $this->address = $this->certificate->address;
        $this->email = $this->certificate->email;
        $this->phone = $this->certificate->phone;

        $this->first_witness_full_name = $this->certificate->first_witness_full_name;
        $this->first_witness_birth_date = $this->certificate->first_witness_birth_date ? \Carbon\Carbon::parse($this->certificate->first_witness_birth_date)->format('Y-m-d') : '';
        $this->first_witness_address = $this->certificate->first_witness_address;

        $this->second_witness_full_name = $this->certificate->second_witness_full_name;
        $this->second_witness_birth_date = $this->certificate->second_witness_birth_date ? \Carbon\Carbon::parse($this->certificate->second_witness_birth_date)->format('Y-m-d') : '';
        $this->second_witness_address = $this->certificate->second_witness_address;
    }

    public function save()
    {
        $this->validate([
            'certificate_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'curp' => 'required|string|size:18',
            'address' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'birth_certificate_file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'proof_of_address_file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'photo_file' => 'nullable|file|max:5120|mimes:jpg,jpeg,png',
            'first_witness_full_name' => 'required|string|max:255',
            'first_witness_birth_date' => 'required|date',
            'first_witness_address' => 'required|string',
            'first_witness_ine_file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'second_witness_full_name' => 'required|string|max:255',
            'second_witness_birth_date' => 'required|date',
            'second_witness_address' => 'required|string',
            'second_witness_ine_file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ], [
            'certificate_type.required' => 'El tipo de constancia es obligatorio.',
            'full_name.required' => 'El nombre completo es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'curp.required' => 'El CURP es obligatorio.',
            'curp.size' => 'El CURP debe tener 18 caracteres.',
            'address.required' => 'El domicilio es obligatorio.',
            'birth_certificate_file.required' => 'El acta de nacimiento es obligatoria.',
            'proof_of_address_file.required' => 'El comprobante de domicilio es obligatorio.',
            'first_witness_full_name.required' => 'El nombre del primer testigo es obligatorio.',
            'first_witness_birth_date.required' => 'La fecha de nacimiento del primer testigo es obligatoria.',
            'first_witness_address.required' => 'El domicilio del primer testigo es obligatorio.',
            'first_witness_ine_file.required' => 'El INE del primer testigo es obligatorio.',
            'second_witness_full_name.required' => 'El nombre del segundo testigo es obligatorio.',
            'second_witness_birth_date.required' => 'La fecha de nacimiento del segundo testigo es obligatoria.',
            'second_witness_address.required' => 'El domicilio del segundo testigo es obligatorio.',
            'second_witness_ine_file.required' => 'El INE del segundo testigo es obligatorio.',
        ]);

        $folio = $this->generateFolio();

        $birth_certificate_url = $this->handleUpload($this->birth_certificate_file, 'birth_certificate');
        $proof_of_address_url = $this->handleUpload($this->proof_of_address_file, 'proof_of_address');
        $photo_url = $this->photo_file ? $this->handleUpload($this->photo_file, 'photo') : null;
        $first_witness_ine_url = $this->handleUpload($this->first_witness_ine_file, 'first_witness_ine');
        $second_witness_ine_url = $this->handleUpload($this->second_witness_ine_file, 'second_witness_ine');

        $certificate = IdentificationCertificate::create([
            'user_id' => Auth::id(),
            'folio' => $folio,
            'certificate_type' => $this->certificate_type,
            'full_name' => $this->full_name,
            'birth_date' => $this->birth_date,
            'curp' => strtoupper($this->curp),
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => 'Solicitud nueva',
            'birth_certificate_file' => $birth_certificate_url,
            'proof_of_address_file' => $proof_of_address_url,
            'photo_file' => $photo_url,
            'first_witness_full_name' => $this->first_witness_full_name,
            'first_witness_birth_date' => $this->first_witness_birth_date,
            'first_witness_address' => $this->first_witness_address,
            'first_witness_ine_file' => $first_witness_ine_url,
            'second_witness_full_name' => $this->second_witness_full_name,
            'second_witness_birth_date' => $this->second_witness_birth_date,
            'second_witness_address' => $this->second_witness_address,
            'second_witness_ine_file' => $second_witness_ine_url,
        ]);

        Session::flash('success', 'Tu solicitud ha sido enviada correctamente. Folio: ' . $folio);

        return redirect()->route('citizen.profile.identification_certificates.show', $certificate->id);
    }

    protected function generateFolio()
    {
        $year = date('Y');
        $lastCertificate = IdentificationCertificate::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastCertificate ? intval(substr($lastCertificate->folio, -4)) + 1 : 1;

        return 'CI' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    protected function handleUpload($document, $type)
    {
        $extension = $document->getClientOriginalExtension();
        $filename = $type . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        $filepath = 'identification_certificates/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('front.user_profiles.citizen.identification_certificates.utilities.crud');
    }
}
