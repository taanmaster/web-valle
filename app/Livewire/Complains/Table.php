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
        $complain = CitizenComplain::find($id);

        $filename = "denuncia_" . Str::slug($complain->id) . ".pdf";

        $pdf = PDF::loadView('complains.utilities.pdf', [
            'complain' => $complain
        ]);

        // Crear directorio si no existe
        $directory = public_path('complains/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdf->save($directory . $filename);

        // Mensaje de session
        Session::flash('success', 'Denuncia descargada exitosamente.');

        return response()->download($directory . $filename);
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
