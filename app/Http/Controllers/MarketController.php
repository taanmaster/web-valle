<?php

namespace App\Http\Controllers;

use App\Models\MarketCut;
use App\Models\MarketRate;
use App\Models\MarketStall;
use App\Models\MarketTicket;

/**
 * Mercado Municipal. Las pantallas son componentes Livewire; aquí sólo se arman las páginas.
 */
class MarketController extends Controller
{
    private function page(string $title, string $eyebrow, string $heading, string $component, array $params = [], ?array $action = null, string $subtitle = '')
    {
        return view('market.page', compact('title', 'eyebrow', 'heading', 'component', 'params', 'action', 'subtitle'));
    }

    public function stalls()
    {
        return $this->page('Padrón', '1 · Padrón', 'Padrón y cartera', 'market.stalls.table', [],
            ['+ Nuevo registro', route('market.stalls.create')],
            'Encuentra a un locatario, revisa si está al corriente y da seguimiento a quien debe.');
    }

    public function createStall()
    {
        return $this->page('Nuevo registro', '1 · Padrón', 'Alta en el padrón', 'market.stalls.form', ['stall' => null],
            ['← Padrón', route('market.stalls.index')]);
    }

    public function editStall(MarketStall $stall)
    {
        return $this->page('Editar registro', '1 · Padrón', 'Editar '.$stall->number, 'market.stalls.form', ['stall' => $stall],
            ['← Volver', route('market.stalls.show', $stall)]);
    }

    public function showStall(MarketStall $stall)
    {
        return $this->page($stall->number, '1 · Padrón', '', 'market.stalls.show', ['stall' => $stall],
            ['← Padrón', route('market.stalls.index')]);
    }

    public function collect()
    {
        return $this->page('Cobrar', '2 · Cobrar', 'Cobrar en ventanilla', 'market.tickets.collect', [], null,
            'Busca al locatario, marca los meses que paga y se imprimen sus boletas.');
    }

    public function tickets()
    {
        return $this->page('Boletas', '3 · Boletas', 'Boletas', 'market.tickets.table', [],
            ['+ Cobrar', route('market.tickets.collect')],
            'Cada boleta, desde que se cobra hasta que el locatario recibe su recibo de Tesorería.');
    }

    public function showTicket(MarketTicket $ticket)
    {
        return $this->page($ticket->folio_label, '3 · Boletas', '', 'market.tickets.show', ['ticket' => $ticket],
            ['← Boletas', route('market.tickets.index')]);
    }

    public function cuts()
    {
        return $this->page('Cortes', '4 · Corte del día', 'Cortes', 'market.cuts.table', [], null,
            'Lo cobrado que se entregó a Tesorería y sus recibos.');
    }

    public function createCut()
    {
        return $this->page('Corte del día', '4 · Corte del día', 'Corte del día', 'market.cuts.create', [],
            ['← Cortes', route('market.cuts.index')]);
    }

    public function showCut(MarketCut $cut)
    {
        return $this->page('Corte '.$cut->cut_date->format('d/m/Y'), '', '', 'market.cuts.show', ['cut' => $cut],
            ['← Cortes', route('market.cuts.index')]);
    }

    public function rates()
    {
        return $this->page('Tarifas', '5 · Tarifas', 'Tarifas', 'market.rates.table', [],
            ['+ Nueva tarifa', route('market.rates.create')],
            'Montos oficiales por tipo de espacio y su fundamento legal. El padrón toma de aquí su cuota mensual.');
    }

    public function createRate()
    {
        return $this->page('Nueva tarifa', '5 · Tarifas', 'Nueva tarifa', 'market.rates.form', ['rate' => null],
            ['← Tarifas', route('market.rates.index')]);
    }

    public function editRate(MarketRate $rate)
    {
        return $this->page('Editar tarifa', '5 · Tarifas', 'Editar tarifa', 'market.rates.form', ['rate' => $rate],
            ['← Tarifas', route('market.rates.index')]);
    }
}
