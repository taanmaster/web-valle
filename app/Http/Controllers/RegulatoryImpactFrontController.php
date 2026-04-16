<?php

namespace App\Http\Controllers;

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
