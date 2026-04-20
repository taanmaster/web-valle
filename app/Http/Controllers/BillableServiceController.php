<?php

namespace App\Http\Controllers;

use App\Models\BillableService;
use Illuminate\Http\Request;

class BillableServiceController extends Controller
{
    public function index()
    {
        $services = BillableService::latest()->paginate(20);
        return view('backoffice.billable_services.index', compact('services'));
    }

    public function create()
    {
        return view('backoffice.billable_services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_price'  => 'required|numeric|min:0',
            'is_active'   => 'boolean',
        ]);

        BillableService::create([
            'name'        => $request->name,
            'description' => $request->description,
            'unit_price'  => $request->unit_price,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.billable_services.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function show(BillableService $servicio)
    {
        return view('backoffice.billable_services.show', compact('servicio'));
    }

    public function edit(BillableService $servicio)
    {
        return view('backoffice.billable_services.edit', compact('servicio'));
    }

    public function update(Request $request, BillableService $servicio)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_price'  => 'required|numeric|min:0',
            'is_active'   => 'boolean',
        ]);

        $servicio->update([
            'name'        => $request->name,
            'description' => $request->description,
            'unit_price'  => $request->unit_price,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.billable_services.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(BillableService $servicio)
    {
        $servicio->delete();

        return redirect()->route('admin.billable_services.index')
            ->with('success', 'Servicio eliminado.');
    }
}
