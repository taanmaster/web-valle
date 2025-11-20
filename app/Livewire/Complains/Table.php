<?php

namespace App\Livewire\Complains;

use Livewire\Component;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Carbon\Carbon;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Http\Request;

//Modelos
use App\Models\CitizenComplain;


class Table extends Component
{
    use WithPagination;

    public $start_date = '';
    public $end_date = '';

    public $status = [];

    public function mount() {}

    public function resetFilters()
    {
        $this->start_date = '';
        $this->end_date = '';
    }

    public function downloadFile($id)
    {
        $complain = CitizenComplain::findOrFail($id);

        // ---------------------------------------------------
        // 1. Generar PDF
        // ---------------------------------------------------
        $pdfFilename = "denuncia_" . Str::slug($complain->id) . ".pdf";

        $pdf = PDF::loadView('complains.utilities.pdf', [
            'complain' => $complain
        ]);

        // Carpeta temporal para agrupar archivos del ZIP
        $tempFolder = public_path('complains/tmp_' . $complain->id . '/');
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0755, true);
        }

        // Guardar PDF dentro del folder temporal
        $pdf->save($tempFolder . $pdfFilename);

        // ---------------------------------------------------
        // 2. Agregar archivo INE (si existe)
        // ---------------------------------------------------
        if ($complain->ine) {
            $inePath = public_path('ine/' . $complain->ine);

            if (file_exists($inePath)) {
                copy($inePath, $tempFolder . $complain->ine);
            }
        }

        // ---------------------------------------------------
        // 3. Agregar archivos relacionados de citizen_complain_files
        // ---------------------------------------------------
        foreach ($complain->files as $file) {   // relación: complain->files
            $path = public_path($file->filename);

            if (file_exists($path)) {
                $destination = $tempFolder . $file->name . '.' . $file->file_extension;
                copy($path, $destination);
            }
        }

        // ---------------------------------------------------
        // 4. Crear ZIP
        // ---------------------------------------------------
        $zipFilename = 'denuncia_' . $complain->id . '.zip';
        $zipPath = public_path('complains/' . $zipFilename);

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Agregar todos los archivos del tempFolder al zip
            foreach (glob($tempFolder . '*') as $filePath) {
                $zip->addFile($filePath, basename($filePath));
            }

            $zip->close();
        }

        // ---------------------------------------------------
        // 5. (Opcional) Eliminar carpeta temporal
        // ---------------------------------------------------
        foreach (glob($tempFolder . '*') as $file) {
            unlink($file);
        }
        rmdir($tempFolder);

        // ---------------------------------------------------
        // 6. Descargar ZIP
        // ---------------------------------------------------
        Session::flash('success', 'Denuncia descargada exitosamente.');

        return response()->download($zipPath);
    }

    public function updateStatus($id)
    {
        $complain = CitizenComplain::findOrFail($id);

        $complain->status = $this->status[$id] ?? null;
        $complain->save();
    }

    public function render()
    {
        $query = CitizenComplain::query();

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        $complains = $query->latest()->paginate(8);


        return view('complains.utilities.table', [
            'complains' => $complains
        ]);
    }
}
