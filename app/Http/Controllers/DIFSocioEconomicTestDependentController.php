<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFSocioEconomicTestDependent as TestDependent;
use App\Models\DIFSocioEconomicTest as Test;

use Illuminate\Http\Request;

class DIFSocioEconomicTestDependentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = TestDependent::query();

        if (request('search')) {
            $s = request('search');
            $query->where('name', 'LIKE', "%{$s}%")
                  ->orWhere('relationship', 'LIKE', "%{$s}%")
                  ->orWhere('occupation', 'LIKE', "%{$s}%");
        }

        $dependents = $query->orderBy('created_at', 'desc')->paginate(30);

        return view('dif.socio_economic_test_dependents.index', compact('dependents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tests = Test::orderBy('created_at', 'desc')->get();
        return view('dif.socio_economic_test_dependents.create', compact('tests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'socio_economic_test_id' => 'required|integer|exists:d_i_f_socio_economic_tests,id',
            'name' => 'nullable|max:255',
            'age' => 'nullable|integer',
            'relationship' => 'nullable|max:255',
            'schooling' => 'nullable|max:255',
            'marital_status' => 'nullable|max:255',
            'weekly_income' => 'nullable|max:255',
            'monthly_income' => 'nullable|max:255',
            'occupation' => 'nullable|max:255',
        ]);

        $dependent = TestDependent::create($request->all());

        Session::flash('success', 'Dependiente guardado correctamente.');
        return redirect()->route('dif.socio_economic_test_dependents.show', $dependent->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dependent = TestDependent::findOrFail($id);
        return view('dif.socio_economic_test_dependents.show', compact('dependent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dependent = TestDependent::findOrFail($id);
        $tests = Test::orderBy('created_at', 'desc')->get();
        return view('dif.socio_economic_test_dependents.edit', compact('dependent', 'tests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'socio_economic_test_id' => 'required|integer|exists:d_i_f_socio_economic_tests,id',
            'name' => 'nullable|max:255',
            'age' => 'nullable|integer',
            'relationship' => 'nullable|max:255',
            'schooling' => 'nullable|max:255',
            'marital_status' => 'nullable|max:255',
            'weekly_income' => 'nullable|max:255',
            'monthly_income' => 'nullable|max:255',
            'occupation' => 'nullable|max:255',
        ]);

        $dependent = TestDependent::findOrFail($id);
        $dependent->update($request->all());

        Session::flash('success', 'Dependiente actualizado correctamente.');
        return redirect()->route('dif.socio_economic_test_dependents.show', $dependent->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dependent = TestDependent::findOrFail($id);
        $dependent->delete();

        Session::flash('success', 'Dependiente eliminado correctamente.');
        return redirect()->route('dif.socio_economic_test_dependents.index');
        }
}
