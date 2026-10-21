<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CivilProtectionCase;
use App\Models\CivilProtectionProcedure;
use Auth;

class CivilProtectionController extends Controller
{
    /**
     * Protección Civil — tarjetas de los trámites publicados
     */
    public function hub()
    {
        $procedures = CivilProtectionProcedure::where('is_published', true)->orderBy('name')->get();

        return view('front.user_profiles.citizen.civil_protection.hub', compact('procedures'));
    }

    /**
     * Protección Civil — Mis trámites (en línea y los creados en ventanilla vinculados a su cuenta)
     */
    public function index()
    {
        $cases = CivilProtectionCase::with('procedure')
            ->where('user_id', Auth::id())
            ->latest('updated_at')
            ->get();

        return view('front.user_profiles.citizen.civil_protection.index', compact('cases'));
    }

    /**
     * Inicia una solicitud en línea: retoma el borrador del trámite si ya existe.
     * El borrador se crea hasta que el ciudadano sube su primer documento o guarda.
     */
    public function start(CivilProtectionProcedure $procedure)
    {
        abort_unless($procedure->is_published, 404);

        $draft = CivilProtectionCase::where('user_id', Auth::id())
            ->where('civil_protection_procedure_id', $procedure->id)
            ->where('status', 'borrador')
            ->first();

        if ($draft) {
            return redirect()->route('citizen.civil_protection.edit', $draft);
        }

        return view('front.user_profiles.citizen.civil_protection.edit', ['case' => null, 'procedure' => $procedure]);
    }

    public function edit(CivilProtectionCase $case)
    {
        abort_unless($case->user_id === Auth::id(), 404);

        if ($case->status !== 'borrador') {
            return redirect()->route('citizen.civil_protection.show', $case);
        }

        return view('front.user_profiles.citizen.civil_protection.edit', ['case' => $case, 'procedure' => $case->procedure]);
    }

    public function show(CivilProtectionCase $case)
    {
        abort_unless($case->user_id === Auth::id(), 404);

        if ($case->status === 'borrador') {
            return redirect()->route('citizen.civil_protection.edit', $case);
        }

        return view('front.user_profiles.citizen.civil_protection.show', compact('case'));
    }
}
