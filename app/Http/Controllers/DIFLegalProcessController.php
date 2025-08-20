<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\DIFLegalProcess as LegalProcess;

use Illuminate\Http\Request;

class DIFLegalProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = LegalProcess::query();

        if (request('search')) {
            $s = request('search');
            $query->where('case_num', 'LIKE', "%{$s}%")
                  ->orWhere('advised_person', 'LIKE', "%{$s}%")
                  ->orWhere('sued_person', 'LIKE', "%{$s}%")
                  ->orWhere('status', 'LIKE', "%{$s}%");
        }

        $processes = $query->orderBy('created_at', 'desc')->paginate(30);

        return view('dif.legal_processes.index', compact('processes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('dif.legal_processes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'case_num' => 'required|max:255|unique:d_i_f_legal_processes,case_num',
            'advised_person' => 'required|max:255',
            'sued_person' => 'required|max:255',
            'status' => 'nullable|max:100',
            'advised_phone' => 'nullable|max:50',
            'advised_age' => 'nullable|max:10',
            'advised_median_income' => 'nullable|max:100',
            'sued_age' => 'nullable|max:10',
            'sued_median_income' => 'nullable|max:100',
            'cost' => 'nullable|max:100',
            'socio_economic_test_id' => 'nullable|integer'
        ]);

        $process = LegalProcess::create($request->all());

        Session::flash('success', 'Caso legal creado correctamente.');

        return redirect()->route('dif.legal_processes.show', $process->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $process = LegalProcess::findOrFail($id);

        return view('dif.legal_processes.show', compact('process'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $process = LegalProcess::findOrFail($id);

        return view('dif.legal_processes.edit', compact('process'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'case_num' => 'required|max:255|unique:d_i_f_legal_processes,case_num,' . $legal_process->id,
            'advised_person' => 'required|max:255',
            'sued_person' => 'required|max:255',
            'status' => 'nullable|max:100',
            'advised_phone' => 'nullable|max:50',
            'advised_age' => 'nullable|max:10',
            'advised_median_income' => 'nullable|max:100',
            'sued_age' => 'nullable|max:10',
            'sued_median_income' => 'nullable|max:100',
            'cost' => 'nullable|max:100',
            'socio_economic_test_id' => 'nullable|integer'
        ]);

        $legal_process = LegalProcess::findOrFail($id);
    
        $legal_process->update($request->all());

        Session::flash('success', 'Caso legal actualizado correctamente.');

        return redirect()->route('dif.legal_processes.show', $legal_process->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $legal_process = LegalProcess::findOrFail($id);
        
        $legal_process->delete();

        Session::flash('success', 'Caso legal eliminado correctamente.');
        return redirect()->route('dif.legal_processes.index');
    }
}
