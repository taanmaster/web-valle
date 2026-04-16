<?php

namespace App\Http\Controllers;

/**
 * ============================================================
 * MÓDULO CIUDADANO: Análisis de Impacto Regulatorio (AIR) y Exención
 * ============================================================
 *
 * FLUJO CIUDADANO (portal público):
 *
 * 1. LANDING
 *    - El ciudadano accede a /impacto-regulatorio y ve dos
 *      tarjetas: AIR y Solicitudes de Exención, con una tabla
 *      de los últimos registros publicados en cada tipo.
 *
 * 2. LISTADOS
 *    - /impacto-regulatorio/air → lista paginada de AIR
 *      visibles (show_in_front = true).
 *    - /impacto-regulatorio/exenciones → lista paginada de
 *      Exenciones visibles.
 *
 * 3. DETALLE
 *    - El ciudadano puede ver el Formato de Solicitud del
 *      registro embebido como PDF (o descargarlo si el
 *      navegador no lo soporta).
 *    - Si existe un Dictamen Final también puede descargarlo.
 *
 * 4. CONSULTA PÚBLICA
 *    - Cualquier visitante puede dejar un comentario público
 *      en la sección de Consulta Pública de cada detalle.
 *    - Se requiere resolver un captcha para evitar spam.
 *    - Una cookie `ri_commented_{id}` limita a un comentario
 *      por registro cada 7 días desde el mismo navegador.
 *
 * ============================================================
 * Solo se muestran registros con show_in_front = true.
 * Los comentarios ciudadanos son visibles también en el
 * backoffice dentro de la sección "Consulta Pública" del detalle.
 * ============================================================
 */

use App\Models\RegulatoryImpact;
use App\Models\RegulatoryImpactComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegulatoryImpactFrontController extends Controller
{
    /**
     * Listado público de registros visibles (show_in_front = true).
     */
    public function index()
    {
        $airRecords = RegulatoryImpact::air()
            ->visibleInFront()
            ->with('dependency')
            ->latest()
            ->paginate(10, ['*'], 'page_air');

        $exencionRecords = RegulatoryImpact::exencion()
            ->visibleInFront()
            ->with('dependency')
            ->latest()
            ->paginate(10, ['*'], 'page_ex');

        $airCount      = $airRecords->total();
        $exencionCount = $exencionRecords->total();

        return view('front.regulatory_impact.index', compact('airRecords', 'exencionRecords', 'airCount', 'exencionCount'));
    }

    /**
     * Listado público paginado de registros AIR.
     */
    public function airIndex()
    {
        $records = RegulatoryImpact::air()
            ->visibleInFront()
            ->with('dependency')
            ->latest()
            ->paginate(12);

        return view('front.regulatory_impact.air_index', compact('records'));
    }

    /**
     * Listado público paginado de solicitudes de Exención.
     */
    public function exencionIndex()
    {
        $records = RegulatoryImpact::exencion()
            ->visibleInFront()
            ->with('dependency')
            ->latest()
            ->paginate(12);

        return view('front.regulatory_impact.exencion_index', compact('records'));
    }

    /**
     * Detalle público de una AIR.
     */
    public function airShow($id)
    {
        $record = RegulatoryImpact::air()
            ->visibleInFront()
            ->with('dependency', 'comments')
            ->findOrFail($id);

        $publicComments = $record->comments()->public()->latest()->get();
        $hasCommented  = (bool) request()->cookie('ri_commented_' . $record->id);

        return view('front.regulatory_impact.air_show', compact('record', 'publicComments', 'hasCommented'));
    }

    /**
     * Detalle público de una Exención.
     */
    public function exencionShow($id)
    {
        $record = RegulatoryImpact::exencion()
            ->visibleInFront()
            ->with('dependency', 'comments')
            ->findOrFail($id);

        $publicComments = $record->comments()->public()->latest()->get();
        $hasCommented  = (bool) request()->cookie('ri_commented_' . $record->id);

        return view('front.regulatory_impact.excension_show', compact('record', 'publicComments', 'hasCommented'));
    }

    /**
     * Guardar comentario de Consulta Pública (ciudadano).
     */
    public function storePublicComment(Request $request, $id)
    {
        $record = RegulatoryImpact::visibleInFront()->findOrFail($id);

        $this->validate($request, [
            'content' => 'required|string|max:2000',
            'captcha' => 'required|captcha',
        ], [
            'content.required' => 'El comentario no puede estar vacío.',
            'captcha.required' => 'El captcha es obligatorio.',
            'captcha.captcha'  => 'El captcha no es correcto. Inténtalo de nuevo.',
        ]);

        RegulatoryImpactComment::create([
            'regulatory_impact_id' => $record->id,
            'user_id'              => null,
            'citizen_id'           => null,
            'comment_type'         => 'public',
            'content'              => $request->content,
        ]);

        Session::flash('success', 'Tu comentario fue registrado exitosamente.');

        $route = $record->isAir()
            ? route('front.regulatory_impact.air_show', $record->id)
            : route('front.regulatory_impact.exencion_show', $record->id);

        $cookie = cookie('ri_commented_' . $record->id, '1', 60 * 24 * 7); // 7 días

        return redirect($route . '#consulta-publica')->withCookie($cookie);
    }
}
