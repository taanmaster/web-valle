<?php

namespace App\Http\Controllers;

// Ayudantes
use Auth;
use Session;
use Str;

// Modelos
use App\Models\DIFSocioEconomicTest as SocioEconomicTest;
use App\Models\DIFCoordination;
use App\Models\User;

use Illuminate\Http\Request;

class DIFSocioEconomicTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = SocioEconomicTest::with(['coordination', 'user', 'createdBy']);

        if (request('search')) {
            $s = request('search');
            $query->where(function($q) use ($s) {
                $q->where('citizen_name', 'LIKE', "%{$s}%")
                  ->orWhere('citizen_last_name', 'LIKE', "%{$s}%")
                  ->orWhere('citizen_curp', 'LIKE', "%{$s}%")
                  ->orWhere('status', 'LIKE', "%{$s}%");
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $tests = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('dif.socio_economic_tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coordinations = DIFCoordination::where('is_active', true)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('dif.socio_economic_tests.create', compact('coordinations', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'coordination_id' => 'required|exists:d_i_f_coordinations,id',
            'citizen_id' => 'required|exists:users,id',
            'citizen_name' => 'required|string|max:255',
            'citizen_last_name' => 'required|string|max:255',
            'citizen_curp' => 'required|string|unique:d_i_f_socio_economic_tests,citizen_curp',
            'citizen_phone' => 'required|string|max:20',
            'citizen_address' => 'required|string',
            'support_type' => 'required|string|max:255',
            'reference_phone' => 'nullable|string|max:20'
        ]);

        $test = SocioEconomicTest::create([
            'coordination_id' => $request->coordination_id,
            'citizen_id' => $request->citizen_id,
            'citizen_name' => $request->citizen_name,
            'citizen_last_name' => $request->citizen_last_name,
            'citizen_curp' => strtoupper($request->citizen_curp),
            'citizen_phone' => $request->citizen_phone,
            'citizen_address' => $request->citizen_address,
            'status' => 'draft',
            'current_step' => 1,
            'can_go_back' => false,
            'step_1_score' => 0,
            'step_1_answers' => [
                'support_type' => $request->support_type,
                'reference_phone' => $request->reference_phone
            ],
            'created_by' => Auth::id()
        ]);

        Session::flash('success', 'Estudio socioeconómico creado correctamente. Puede continuar con el paso 2.');
        
        return redirect()->route('dif.socio_economic_tests.step2', $test->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $test = SocioEconomicTest::with(['coordination', 'user', 'dependents', 'files', 'createdBy', 'approvedBy'])
                                 ->findOrFail($id);

        return view('dif.socio_economic_tests.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        // Solo se puede editar si está en borrador
        if ($test->status !== 'draft') {
            Session::flash('error', 'Solo se pueden editar estudios en estado borrador.');
            return redirect()->route('dif.socio_economic_tests.show', $test->id);
        }

        $coordinations = DIFCoordination::where('is_active', true)->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('dif.socio_economic_tests.edit', compact('test', 'coordinations', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        if ($test->status !== 'draft') {
            Session::flash('error', 'Solo se pueden editar estudios en estado borrador.');
            return redirect()->route('dif.socio_economic_tests.show', $test->id);
        }

        $this->validate($request, [
            'coordination_id' => 'required|exists:d_i_f_coordinations,id',
            'user_id' => 'required|exists:users,id',
            'citizen_name' => 'required|string|max:255',
            'citizen_last_name' => 'required|string|max:255',
            'citizen_curp' => 'required|string|size:18|unique:d_i_f_socio_economic_tests,citizen_curp,' . $test->id,
            'citizen_phone' => 'required|string|max:20',
            'citizen_address' => 'required|string'
        ]);

        $test->update($request->only([
            'coordination_id', 'user_id', 'citizen_name', 'citizen_last_name',
            'citizen_curp', 'citizen_phone', 'citizen_address'
        ]));

        Session::flash('success', 'Estudio socioeconómico actualizado correctamente.');
        return redirect()->route('dif.socio_economic_tests.show', $test->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        // Solo se puede eliminar si está en borrador
        if ($test->status !== 'draft') {
            Session::flash('error', 'Solo se pueden eliminar estudios en estado borrador.');
            return redirect()->route('dif.socio_economic_tests.index');
        }

        $test->delete();

        Session::flash('success', 'Estudio socioeconómico eliminado correctamente.');
        return redirect()->route('dif.socio_economic_tests.index');
    }

    // Métodos para los pasos del formulario

    public function step2($id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        if (!$test->canAdvanceToStep(2)) {
            Session::flash('error', 'Debe completar el paso anterior para continuar.');
            return redirect()->route('dif.socio_economic_tests.show', $test->id);
        }

        return view('dif.socio_economic_tests.step2', compact('test'));
    }

    public function storeStep2(Request $request, $id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        $this->validate($request, [
            'civil_status' => 'required|string',
            'age_range' => 'required|string',
            'occupation' => 'required|string',
            'education' => 'required|string'
        ]);

        // Calcular puntaje del paso 2
        $score = $this->calculateStep2Score($request);

        $test->update([
            'step_2_answers' => $request->only(['civil_status', 'age_range', 'occupation', 'education']),
            'step_2_score' => $score,
            'current_step' => 3
        ]);

        Session::flash('success', "Paso 2 completado. Puntaje obtenido: {$score} puntos.");
        return redirect()->route('dif.socio_economic_tests.step3', $test->id);
    }

    public function step3($id)
    {
        $test = SocioEconomicTest::with('dependents')->findOrFail($id);
        
        if (!$test->canAdvanceToStep(3)) {
            Session::flash('error', 'Debe completar el paso anterior para continuar.');
            return redirect()->route('dif.socio_economic_tests.show', $test->id);
        }

        return view('dif.socio_economic_tests.step3', compact('test'));
    }

    public function storeStep3(Request $request, $id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        $this->validate($request, [
            'dependents_count' => 'required|integer|min:0'
        ]);

        // Calcular puntaje del paso 3
        $score = $this->calculateStep3Score($request->dependents_count);

        $test->update([
            'step_3_answers' => ['dependents_count' => $request->dependents_count],
            'step_3_score' => $score,
            'current_step' => 4
        ]);

        Session::flash('success', "Paso 3 completado. Puntaje obtenido: {$score} puntos.");
        return redirect()->route('dif.socio_economic_tests.step4', $test->id);
    }

    public function step4($id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        if (!$test->canAdvanceToStep(4)) {
            Session::flash('error', 'Debe completar el paso anterior para continuar.');
            return redirect()->route('dif.socio_economic_tests.show', $test->id);
        }

        return view('dif.socio_economic_tests.step4', compact('test'));
    }

    public function storeStep4(Request $request, $id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        $this->validate($request, [
            'monthly_expenses' => 'nullable|numeric',
            'monthly_debt' => 'nullable|numeric',
            'monthly_savings' => 'nullable|numeric',
            'income_level' => 'required|string',
            'expense_level' => 'required|string'
        ]);

        // Calcular puntaje del paso 4
        $score = $this->calculateStep4Score($request);

        $test->update([
            'step_4_answers' => $request->only([
                'monthly_expenses', 'monthly_debt', 'monthly_savings', 
                'income_level', 'expense_level'
            ]),
            'step_4_score' => $score,
            'current_step' => 5
        ]);

        Session::flash('success', "Paso 4 completado. Puntaje obtenido: {$score} puntos.");
        return redirect()->route('dif.socio_economic_tests.step5', $test->id);
    }

    public function step5($id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        if (!$test->canAdvanceToStep(5)) {
            Session::flash('error', 'Debe completar el paso anterior para continuar.');
            return redirect()->route('dif.socio_economic_tests.show', $test->id);
        }

        return view('dif.socio_economic_tests.step5', compact('test'));
    }

    public function storeStep5(Request $request, $id)
    {
        $test = SocioEconomicTest::findOrFail($id);
        
        $this->validate($request, [
            'medical_service' => 'required|string',
            'chronic_illness' => 'required|string',
            'housing_type' => 'required|string',
            'water_service' => 'required|string',
            'electricity_service' => 'required|string',
            'drainage_service' => 'required|string',
            'gas_service' => 'required|string',
            'roof_type' => 'required|string',
            'wall_type' => 'required|string',
            'floor_type' => 'required|string',
            'rooms_count' => 'required|string'
        ]);

        // Calcular puntaje del paso 5
        $score = $this->calculateStep5Score($request);

        // Calcular puntaje total y nivel de vulnerabilidad
        $totalScore = ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + 
                     ($test->step_3_score ?? 0) + ($test->step_4_score ?? 0) + $score;

        $support = $test->getRecommendedSupport();

        $test->update([
            'step_5_answers' => $request->only([
                'medical_service', 'chronic_illness', 'housing_type', 'water_service',
                'electricity_service', 'drainage_service', 'gas_service', 'roof_type',
                'wall_type', 'floor_type', 'rooms_count'
            ]),
            'step_5_score' => $score,
            'total_score' => $totalScore,
            'vulnerability_level' => $test->getVulnerabilityLevel(),
            'recommended_support_type' => $support['type'],
            'recommended_amount' => $support['amount'],
            'status' => 'completed'
        ]);

        Session::flash('success', "¡Estudio socioeconómico completado! Puntaje total: {$totalScore} puntos. Nivel: {$test->getVulnerabilityLevelText()}");
        return redirect()->route('dif.socio_economic_tests.show', $test->id);
    }

    // Métodos AJAX para cálculo en tiempo real
    public function updateScore(Request $request)
    {
        $step = $request->step;
        $testId = $request->test_id;
        
        $test = SocioEconomicTest::findOrFail($testId);
        
        // Calcular puntaje según el paso
        $score = 0;
        switch ($step) {
            case 2:
                $score = $this->calculateStep2Score($request);
                break;
            case 3:
                $score = $this->calculateStep3Score($request->dependents_count);
                break;
            case 4:
                $score = $this->calculateStep4Score($request);
                break;
            case 5:
                $score = $this->calculateStep5Score($request);
                break;
        }

        // Calcular total
        $totalScore = ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + 
                     ($test->step_3_score ?? 0) + ($test->step_4_score ?? 0) + ($test->step_5_score ?? 0);
        
        if ($step == 2) $totalScore = ($test->step_1_score ?? 0) + $score + ($test->step_3_score ?? 0) + ($test->step_4_score ?? 0) + ($test->step_5_score ?? 0);
        if ($step == 3) $totalScore = ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + $score + ($test->step_4_score ?? 0) + ($test->step_5_score ?? 0);
        if ($step == 4) $totalScore = ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + ($test->step_3_score ?? 0) + $score + ($test->step_5_score ?? 0);
        if ($step == 5) $totalScore = ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + ($test->step_3_score ?? 0) + ($test->step_4_score ?? 0) + $score;

        return response()->json([
            'step_score' => $score,
            'total_score' => $totalScore,
            'vulnerability_level' => $test->getVulnerabilityLevelText(),
            'vulnerability_description' => $test->getRecommendedSupport()['description']
        ]);
    }

    // Métodos privados para cálculo de puntajes
    private function calculateStep2Score($request)
    {
        $score = 0;
        
        // Estado Civil
        switch ($request->civil_status) {
            case 'single_mother_children':
            case 'widow_children':
                $score += 5;
                break;
            case 'single_mother':
            case 'widow':
                $score += 3;
                break;
            default:
                $score += 1;
                break;
        }

        // Edad
        switch ($request->age_range) {
            case '65_plus':
                $score += 5;
                break;
            case '38_64':
                $score += 4;
                break;
            case '17_37':
                $score += 2;
                break;
            default:
                $score += 1;
                break;
        }

        // Ocupación
        switch ($request->occupation) {
            case 'unemployed':
                $score += 5;
                break;
            case 'eventual':
                $score += 3;
                break;
            case 'retired':
                $score += 2;
                break;
            default:
                $score += 1;
                break;
        }

        // Escolaridad
        switch ($request->education) {
            case 'none':
                $score += 5;
                break;
            case 'primary':
                $score += 3;
                break;
            case 'secondary':
                $score += 2;
                break;
            default:
                $score += 1;
                break;
        }

        return $score;
    }

    private function calculateStep3Score($dependentsCount)
    {
        if ($dependentsCount >= 10) return 5;
        if ($dependentsCount >= 6) return 3;
        if ($dependentsCount >= 3) return 2;
        return 1;
    }

    private function calculateStep4Score($request)
    {
        $score = 0;

        // Ingreso mensual
        switch ($request->income_level) {
            case '0_1':
                $score += 4;
                break;
            case '2_3':
                $score += 3;
                break;
            case '4_5':
                $score += 2;
                break;
            default:
                $score += 1;
                break;
        }

        // Egresos
        switch ($request->expense_level) {
            case 'borrow':
                $score += 5;
                break;
            case 'total':
                $score += 3;
                break;
            default:
                $score += 1;
                break;
        }

        return $score;
    }

    private function calculateStep5Score($request)
    {
        $score = 0;

        // Servicio médico
        switch ($request->medical_service) {
            case 'public_health':
                $score += 5;
                break;
            case 'private':
                $score += 3;
                break;
            default:
                $score += 1;
                break;
        }

        // Enfermedad crónica
        switch ($request->chronic_illness) {
            case 'main_provider':
                $score += 5;
                break;
            case 'dependent_provider':
                $score += 4;
                break;
            case 'children':
                $score += 3;
                break;
            case 'other_family':
                $score += 2;
                break;
        }

        // Condiciones de vivienda
        $housingFields = [
            'housing_type' => ['rent' => 5, 'borrowed' => 4, 'irregular' => 3, 'owned' => 2],
            'water_service' => ['none' => 5, 'irregular' => 3, 'service' => 1],
            'electricity_service' => ['none' => 5, 'irregular' => 3, 'service' => 1],
            'drainage_service' => ['other' => 5, 'latrine' => 3, 'service' => 1],
            'gas_service' => ['wood' => 5, 'butane' => 3, 'natural' => 1],
            'roof_type' => ['other' => 5, 'sheet' => 3, 'concrete' => 1],
            'wall_type' => ['wood_other' => 5, 'cardboard' => 3, 'material' => 1],
            'floor_type' => ['dirt' => 5, 'concrete' => 3, 'finished' => 1],
            'rooms_count' => ['one' => 4, 'two_three' => 3, 'four_plus' => 1]
        ];

        foreach ($housingFields as $field => $values) {
            $value = $request->$field;
            $score += $values[$value] ?? 1;
        }

        return $score;
    }
}
