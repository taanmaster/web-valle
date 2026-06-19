<?php

namespace App\Livewire\Panteon;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Panteon;

class Crud extends Component
{
    use WithFileUploads;

    public $panteon;

    // Modes: 0: create, 1: show, 2: edit
    public $mode;

    // Datos administrativos
    public $entero = '';
    public $folio = '';
    public $fecha = '';
    public $comprobante_pdf = '';

    // Datos del solicitante
    public $nombre_solicitante = '';
    public $nombre_finado = '';
    public $domicilio = '';
    public $localidad = '';

    // Fundamento legal
    public $fundamento_legal = '';

    // Concepto de pago
    public $concepto = '';
    public $tipo = '';
    public $zona = '';
    public $observaciones = '';

    // Ubicación del panteón
    public $panteon_nombre = '';
    public $seccion = '';
    public $bloque = '';
    public $manzana = '';
    public $terreno = '';

    // Referencia normativa
    public $ref_art = '';
    public $ref_frac = '';
    public $ref_inc = '';
    public $ref_num = '';

    // Monto a pagar
    public $monto = '';
    public $cantidad_letra = '';

    public function mount()
    {
        if ($this->panteon !== null) {
            $this->fetchData();
        } else {
            $this->fecha = Carbon::now()->toDateString();
        }
    }

    public function fetchData()
    {
        $p = $this->panteon;

        $this->entero = $p->entero;
        $this->folio = $p->folio;

        $this->fecha = $p->fecha?->toDateString();

        $this->comprobante_pdf = $p->comprobante_pdf;
        $this->nombre_solicitante = $p->nombre_solicitante;
        $this->nombre_finado = $p->nombre_finado;
        $this->domicilio = $p->domicilio;
        $this->localidad = $p->localidad;
        $this->fundamento_legal = $p->fundamento_legal;
        $this->concepto = $p->concepto;
        $this->tipo = $p->tipo;
        $this->zona = $p->zona;
        $this->observaciones = $p->observaciones;
        $this->panteon_nombre = $p->panteon;
        $this->seccion = $p->seccion;
        $this->bloque = $p->bloque;
        $this->manzana = $p->manzana;
        $this->terreno = $p->terreno;
        $this->ref_art = $p->ref_art;
        $this->ref_frac = $p->ref_frac;
        $this->ref_inc = $p->ref_inc;
        $this->ref_num = $p->ref_num;
        $this->monto = $p->monto;
        $this->cantidad_letra = $p->cantidad_letra;
    }

    public function save()
    {
        $this->validate([
            'entero'             => 'nullable|string|max:255',
            'folio'              => 'nullable|string|max:255',
            'fecha'              => 'nullable|date',
            'comprobante_pdf'    => 'nullable|file|mimes:pdf|max:10240',
            'nombre_solicitante' => 'nullable|string|max:255',
            'nombre_finado'      => 'nullable|string|max:255',
            'domicilio'          => 'nullable|string|max:255',
            'localidad'          => 'nullable|string|max:255',
            'fundamento_legal'   => 'nullable|string|max:255',
            'concepto'           => 'nullable|string|max:255',
            'tipo'               => 'nullable|string|max:255',
            'zona'               => 'nullable|string|max:255',
            'observaciones'      => 'nullable|string',
            'panteon_nombre'     => 'nullable|string|max:255',
            'seccion'            => 'nullable|string|max:255',
            'bloque'             => 'nullable|string|max:255',
            'manzana'            => 'nullable|string|max:255',
            'terreno'            => 'nullable|string|max:255',
            'ref_art'            => 'nullable|string|max:255',
            'ref_frac'           => 'nullable|string|max:255',
            'ref_inc'            => 'nullable|string|max:255',
            'ref_num'            => 'nullable|string|max:255',
            'monto'              => 'nullable|string|max:255',
            'cantidad_letra'     => 'nullable|string|max:255',
        ]);

        $fecha = $this->fecha ?: null;

        // Handle PDF upload
        $pdfName = $this->panteon?->comprobante_pdf;
        if ($this->comprobante_pdf && !is_string($this->comprobante_pdf)) {
            $pdfName = Str::random(8) . '_comprobante.' . $this->comprobante_pdf->getClientOriginalExtension();
            $this->comprobante_pdf->storeAs('panteones/comprobantes', $pdfName, 'public');
        }

        $data = [
            'entero'             => $this->entero,
            'folio'              => $this->folio,
            'fecha'              => $fecha,
            'comprobante_pdf'    => $pdfName,
            'nombre_solicitante' => $this->nombre_solicitante,
            'nombre_finado'      => $this->nombre_finado,
            'domicilio'          => $this->domicilio,
            'localidad'          => $this->localidad,
            'fundamento_legal'   => $this->fundamento_legal,
            'concepto'           => $this->concepto,
            'tipo'               => $this->tipo,
            'zona'               => $this->zona,
            'observaciones'      => $this->observaciones,
            'panteon'            => $this->panteon_nombre,
            'seccion'            => $this->seccion,
            'bloque'             => $this->bloque,
            'manzana'            => $this->manzana,
            'terreno'            => $this->terreno,
            'ref_art'            => $this->ref_art,
            'ref_frac'           => $this->ref_frac,
            'ref_inc'            => $this->ref_inc,
            'ref_num'            => $this->ref_num,
            'monto'              => $this->monto,
            'cantidad_letra'     => $this->cantidad_letra,
        ];

        if ($this->panteon !== null) {
            $this->panteon->update($data);
        } else {
            Panteon::create($data);
        }

        return redirect()->route('panteones.admin.index');
    }

    public function render()
    {
        return view('panteones.utilities.crud');
    }
}
