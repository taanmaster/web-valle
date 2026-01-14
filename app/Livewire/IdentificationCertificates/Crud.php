<?php

namespace App\Livewire\IdentificationCertificates;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\IdentificationCertificate;
use App\Models\IdentificationCertificatePayment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Crud extends Component
{
    use WithFileUploads;

    public $certificate;
    public $mode = 1; // 1: show

    // Para cambiar estatus
    public $status = '';
    public $admin_notes = '';

    // Aprobacion de documentos
    public $birth_certificate_approved = false;
    public $proof_of_address_approved = false;
    public $photo_approved = false;
    public $first_witness_ine_approved = false;
    public $second_witness_ine_approved = false;

    // Datos del pago
    public $payment;
    public $receipt_number = '';
    public $payment_date = '';
    public $payment_status = 'Pendiente';
    public $payment_notes = '';
    public $proof_file;

    public function mount()
    {
        if ($this->certificate) {
            $this->status = $this->certificate->status;
            $this->admin_notes = $this->certificate->admin_notes;

            // Cargar aprobaciones
            $this->birth_certificate_approved = $this->certificate->birth_certificate_approved;
            $this->proof_of_address_approved = $this->certificate->proof_of_address_approved;
            $this->photo_approved = $this->certificate->photo_approved;
            $this->first_witness_ine_approved = $this->certificate->first_witness_ine_approved;
            $this->second_witness_ine_approved = $this->certificate->second_witness_ine_approved;

            // Cargar pago si existe
            $this->payment = $this->certificate->payment;
            if ($this->payment) {
                $this->receipt_number = $this->payment->receipt_number;
                $this->payment_date = $this->payment->payment_date ? \Carbon\Carbon::parse($this->payment->payment_date)->format('Y-m-d') : '';
                $this->payment_status = $this->payment->status;
                $this->payment_notes = $this->payment->notes;
            }
        }
    }

    public function toggleApproval($field)
    {
        $allowedFields = [
            'birth_certificate_approved',
            'proof_of_address_approved',
            'photo_approved',
            'first_witness_ine_approved',
            'second_witness_ine_approved',
        ];

        if (in_array($field, $allowedFields)) {
            $this->$field = !$this->$field;
            $this->certificate->update([$field => $this->$field]);
            Session::flash('message', 'Aprobacion actualizada.');
        }
    }

    public function savePayment()
    {
        $this->validate([
            'receipt_number' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'payment_status' => 'required|string',
            'payment_notes' => 'nullable|string',
            'proof_file' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ]);

        $proof_url = null;
        if ($this->proof_file) {
            $proof_url = $this->handleUpload($this->proof_file);
        } elseif ($this->payment) {
            $proof_url = $this->payment->proof_filename;
        }

        if ($this->payment) {
            $this->payment->update([
                'receipt_number' => $this->receipt_number,
                'payment_date' => $this->payment_date,
                'status' => $this->payment_status,
                'notes' => $this->payment_notes,
                'proof_filename' => $proof_url,
            ]);
        } else {
            $folio = $this->generatePaymentFolio();

            $this->payment = IdentificationCertificatePayment::create([
                'certificate_id' => $this->certificate->id,
                'folio' => $folio,
                'receipt_number' => $this->receipt_number,
                'payment_date' => $this->payment_date,
                'status' => $this->payment_status,
                'notes' => $this->payment_notes,
                'proof_filename' => $proof_url,
            ]);
        }

        if ($this->payment_status === 'Pagado') {
            $this->certificate->update(['status' => 'Pago recibido']);
            $this->status = 'Pago recibido';
        }

        Session::flash('message', 'Informacion de pago guardada correctamente.');
    }

    protected function generatePaymentFolio()
    {
        $year = date('Y');
        $shortYear = date('y');
        $lastPayment = IdentificationCertificatePayment::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastPayment ? intval(substr($lastPayment->folio, -4)) + 1 : 1;

        return 'PCI' . $shortYear . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    protected function handleUpload($document)
    {
        $extension = $document->getClientOriginalExtension();
        $filename = 'payment_proof_' . time() . '_' . Str::random(10) . '.' . $extension;

        $filepath = 'identification_certificates/payments/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function updatedStatus()
    {
        if ($this->certificate) {
            $this->certificate->update([
                'status' => $this->status,
            ]);
            $this->certificate->refresh();
        }

        Session::flash('message', 'Actualizado correctamente.');
    }

    public function updatedPaymentStatus()
    {
        if ($this->payment) {
            $this->payment->update([
                'status' => $this->payment_status,
            ]);
            $this->payment->refresh();
        }
    }

    public function updatedAdminNotes()
    {
        if ($this->certificate) {
            $this->certificate->update([
                'admin_notes' => $this->admin_notes,
            ]);
            $this->certificate->refresh();
        }
    }

    public function render()
    {
        return view('identification_certificates.utilities.crud');
    }
}
