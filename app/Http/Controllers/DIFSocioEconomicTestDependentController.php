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
use Illuminate\Validation\ValidationException;

class DIFSocioEconomicTestDependentController extends Controller
{
    /**
     * Reglas de validación para dependientes
     */
    private function getValidationRules()
    {
        return [
            'socio_economic_test_id' => 'required|integer|exists:d_i_f_socio_economic_tests,id',
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:120',
            'relationship' => 'nullable|string|max:255',
            'schooling' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'weekly_income' => 'nullable|numeric|min:0|max:999999.99',
            'monthly_income' => 'nullable|numeric|min:0|max:999999.99',
            'occupation' => 'nullable|string|max:255',
        ];
    }

    /**
     * Mensajes de validación personalizados
     */
    private function getValidationMessages()
    {
        return [
            'name.required' => 'El nombre del dependiente es obligatorio.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad no puede ser menor a 0.',
            'age.max' => 'La edad no puede ser mayor a 120.',
            'weekly_income.numeric' => 'El ingreso semanal debe ser un número válido.',
            'weekly_income.min' => 'El ingreso semanal no puede ser negativo.',
            'monthly_income.numeric' => 'El ingreso mensual debe ser un número válido.',
            'monthly_income.min' => 'El ingreso mensual no puede ser negativo.',
            'socio_economic_test_id.required' => 'El estudio socioeconómico es requerido.',
            'socio_economic_test_id.exists' => 'El estudio socioeconómico no existe.',
        ];
    }
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
        try {
            $request->validate($this->getValidationRules(), $this->getValidationMessages());

            $dependent = TestDependent::create($request->all());

            // Respuesta para AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dependiente guardado correctamente.',
                    'dependent' => $dependent
                ]);
            }

            Session::flash('success', 'Dependiente guardado correctamente.');
            return redirect()->back();
            
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar el dependiente: ' . $e->getMessage()
                ], 500);
            }
            
            Session::flash('error', 'Error al guardar el dependiente.');
            return redirect()->back();
        }
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
        try {
            $request->validate($this->getValidationRules(), $this->getValidationMessages());

            $dependent = TestDependent::findOrFail($id);
            $dependent->update($request->all());

            // Respuesta para AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dependiente actualizado correctamente.',
                    'dependent' => $dependent->fresh()
                ]);
            }

            Session::flash('success', 'Dependiente actualizado correctamente.');
            return redirect()->route('dif.socio_economic_test_dependents.show', $dependent->id);
            
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el dependiente: ' . $e->getMessage()
                ], 500);
            }
            
            Session::flash('error', 'Error al actualizar el dependiente.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $dependent = TestDependent::findOrFail($id);
            $dependentName = $dependent->name;
            $dependent->delete();

            // Respuesta para AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Dependiente '{$dependentName}' eliminado correctamente."
                ]);
            }

            Session::flash('success', 'Dependiente eliminado correctamente.');
            return redirect()->route('dif.socio_economic_test_dependents.index');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El dependiente no fue encontrado.'
                ], 404);
            }
            
            Session::flash('error', 'El dependiente no fue encontrado.');
            return redirect()->back();
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el dependiente: ' . $e->getMessage()
                ], 500);
            }
            
            Session::flash('error', 'Error al eliminar el dependiente.');
            return redirect()->back();
        }
    }
}
