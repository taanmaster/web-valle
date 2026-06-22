<?php

namespace App\Http\Controllers;

use App\Models\UrbanDevCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UrbanDevCostController extends Controller
{
    /**
     * Listado de trámites con sus líneas de costo (solo lectura).
     */
    public function index()
    {
        $tramites = UrbanDevCost::orderBy('tramite_title')
            ->orderBy('position')
            ->get()
            ->groupBy('tramite_slug');

        return view('urban_dev_costs.index', compact('tramites'));
    }

    /**
     * Formulario para actualizar los montos de un trámite.
     */
    public function edit(string $slug)
    {
        $costs = UrbanDevCost::where('tramite_slug', $slug)
            ->orderBy('position')
            ->get();

        abort_if($costs->isEmpty(), 404);

        return view('urban_dev_costs.edit', [
            'slug'   => $slug,
            'title'  => $costs->first()->tramite_title,
            'costs'  => $costs,
        ]);
    }

    /**
     * Guarda únicamente los montos. La descripción, unidad y contenido no se tocan.
     */
    public function update(Request $request, string $slug)
    {
        $costs = UrbanDevCost::where('tramite_slug', $slug)->get();
        abort_if($costs->isEmpty(), 404);

        $validated = $request->validate([
            'amounts'   => 'required|array',
            'amounts.*' => 'required|numeric|min:0',
        ], [
            'amounts.*.required' => 'Captura todos los montos.',
            'amounts.*.numeric'  => 'El monto debe ser un número.',
            'amounts.*.min'      => 'El monto no puede ser negativo.',
        ]);

        foreach ($costs as $cost) {
            if (array_key_exists($cost->id, $validated['amounts'])) {
                $cost->update(['amount' => $validated['amounts'][$cost->id]]);
            }
        }

        Session::flash('success', 'Costos de "' . $costs->first()->tramite_title . '" actualizados correctamente.');

        return redirect()->route('urban_dev.costs.index');
    }
}
