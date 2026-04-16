<?php

namespace App\Http\Controllers;

use App\Models\BackofficeDependency;
use App\Models\RegulatoryImpact;
use App\Models\RegulatoryImpactComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class RegulatoryImpactController extends Controller
{
    /**
     * Display a listing of the resource (AIR + Exención as separate paginated collections).
     */
    public function index(Request $request)
    {
        $airRecords = RegulatoryImpact::air()
            ->with('dependency', 'user')
            ->latest()
            ->paginate(15, ['*'], 'page_air');

        $exencionRecords = RegulatoryImpact::exencion()
            ->with('dependency', 'user')
            ->latest()
            ->paginate(15, ['*'], 'page_ex');

        return view('regulatory_impact.index', compact('airRecords', 'exencionRecords'));
    }

    /**
     * Show the form for creating a new resource.
     * Receives ?type=air|exencion to determine which form to show.
     */
    public function create(Request $request)
    {
        $type = $request->query('type', RegulatoryImpact::TYPE_AIR);

        if (! in_array($type, [RegulatoryImpact::TYPE_AIR, RegulatoryImpact::TYPE_EXENCION])) {
            $type = RegulatoryImpact::TYPE_AIR;
        }

        $dependencies = BackofficeDependency::orderBy('name')->get();
        $folio        = RegulatoryImpact::generateFolio($type);

        return view('regulatory_impact.create', compact('type', 'dependencies', 'folio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->input('type', RegulatoryImpact::TYPE_AIR);

        $commonRules = [
            'type'         => 'required|in:air,exencion',
            'dependency_id' => 'required|exists:backoffice_dependencies,id',
            'formato_solicitud' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];

        $airRules = [
            'nombre_propuesta'    => 'required|string|max:500',
            'fecha_vigencia'      => 'nullable|date',
            'autoridad_emisora'   => 'nullable|string|max:500',
            'objeto_programa'     => 'nullable|string',
            'tipo_ordenamiento'   => 'nullable|string|max:255',
            'materias_reguladas'  => 'nullable|string|max:255',
            'sectores_regulados'  => 'nullable|string|max:255',
            'sujetos_regulados'   => 'nullable|string|max:255',
            'indice_regulacion'   => 'nullable|string',
            'tramites_relacionados' => 'nullable|string',
        ];

        $exencionRules = [
            'titulo_regulacion' => 'required|string|max:500',
            'nombre_cargo'      => 'nullable|string|max:255',
            'fecha_envio'       => 'nullable|date',
        ];

        $rules = array_merge(
            $commonRules,
            $type === RegulatoryImpact::TYPE_AIR ? $airRules : $exencionRules
        );

        $this->validate($request, $rules);

        $folio = RegulatoryImpact::generateFolio($type);

        $data = array_merge(
            $request->only(array_keys($rules)),
            [
                'folio'   => $folio,
                'user_id' => Auth::id(),
            ]
        );

        // Subir formato de solicitud a S3
        if ($request->hasFile('formato_solicitud')) {
            $file     = $request->file('formato_solicitud');
            $ext      = $file->getClientOriginalExtension();
            $path     = "regulatory_impact/requests/{$folio}.{$ext}";
            Storage::disk('s3')->put($path, file_get_contents($file));
            $data['formato_solicitud']      = $path;
            $data['formato_solicitud_s3_url'] = Storage::disk('s3')->url($path);
        }

        RegulatoryImpact::create($data);

        Session::flash('success', 'Registro guardado exitosamente. Folio: ' . $folio);

        return redirect()->route('institucional_development.regulatory_impact.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RegulatoryImpact $regulatoryImpact)
    {
        $regulatoryImpact->load('dependency', 'user', 'comments.user');

        $adminComments  = $regulatoryImpact->comments()->admin()->with('user')->latest()->get();
        $publicComments = $regulatoryImpact->comments()->public()->latest()->get();

        $dependencies = BackofficeDependency::orderBy('name')->get();

        return view('regulatory_impact.show', compact(
            'regulatoryImpact',
            'adminComments',
            'publicComments',
            'dependencies'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegulatoryImpact $regulatoryImpact)
    {
        $dependencies = BackofficeDependency::orderBy('name')->get();

        return view('regulatory_impact.edit', compact('regulatoryImpact', 'dependencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegulatoryImpact $regulatoryImpact)
    {
        $type = $regulatoryImpact->type;

        $commonRules = [
            'dependency_id'     => 'required|exists:backoffice_dependencies,id',
            'formato_solicitud' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];

        $airRules = [
            'nombre_propuesta'    => 'required|string|max:500',
            'fecha_vigencia'      => 'nullable|date',
            'autoridad_emisora'   => 'nullable|string|max:500',
            'objeto_programa'     => 'nullable|string',
            'tipo_ordenamiento'   => 'nullable|string|max:255',
            'materias_reguladas'  => 'nullable|string|max:255',
            'sectores_regulados'  => 'nullable|string|max:255',
            'sujetos_regulados'   => 'nullable|string|max:255',
            'indice_regulacion'   => 'nullable|string',
            'tramites_relacionados' => 'nullable|string',
        ];

        $exencionRules = [
            'titulo_regulacion' => 'required|string|max:500',
            'nombre_cargo'      => 'nullable|string|max:255',
            'fecha_envio'       => 'nullable|date',
        ];

        $rules = array_merge(
            $commonRules,
            $type === RegulatoryImpact::TYPE_AIR ? $airRules : $exencionRules
        );

        $this->validate($request, $rules);

        $data = $request->only(array_keys($rules));
        unset($data['formato_solicitud']); // no sobreescribir con null

        // Reemplazar formato de solicitud si se sube uno nuevo
        if ($request->hasFile('formato_solicitud')) {
            // Eliminar archivo anterior si existe
            if ($regulatoryImpact->formato_solicitud) {
                Storage::disk('s3')->delete($regulatoryImpact->formato_solicitud);
            }
            $file  = $request->file('formato_solicitud');
            $ext   = $file->getClientOriginalExtension();
            $path  = "regulatory_impact/requests/{$regulatoryImpact->folio}.{$ext}";
            Storage::disk('s3')->put($path, file_get_contents($file));
            $data['formato_solicitud']        = $path;
            $data['formato_solicitud_s3_url'] = Storage::disk('s3')->url($path);
        }

        $regulatoryImpact->update($data);

        Session::flash('success', 'Registro actualizado exitosamente.');

        return redirect()->route('institucional_development.regulatory_impact.show', $regulatoryImpact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegulatoryImpact $regulatoryImpact)
    {
        // Limpiar archivos en S3
        if ($regulatoryImpact->formato_solicitud) {
            Storage::disk('s3')->delete($regulatoryImpact->formato_solicitud);
        }
        if ($regulatoryImpact->dictamen_file) {
            Storage::disk('s3')->delete($regulatoryImpact->dictamen_file);
        }

        $regulatoryImpact->delete();

        Session::flash('success', 'Registro eliminado exitosamente.');

        return redirect()->route('institucional_development.regulatory_impact.index');
    }

    /**
     * Store an admin observation/comment (interna).
     * Solo roles: des_Institucional, all.
     */
    public function storeComment(Request $request, RegulatoryImpact $regulatoryImpact)
    {
        if (! Auth::user()->hasAnyRole(['des_Institucional', 'all'])) {
            abort(403, 'No tienes permiso para publicar observaciones en este módulo.');
        }

        $this->validate($request, [
            'content' => 'required|string|max:2000',
        ], [
            'content.required' => 'El comentario no puede estar vacío.',
        ]);

        RegulatoryImpactComment::create([
            'regulatory_impact_id' => $regulatoryImpact->id,
            'user_id'              => Auth::id(),
            'comment_type'         => 'admin',
            'content'              => $request->content,
        ]);

        Session::flash('success', 'Observación publicada.');

        return redirect()->route('institucional_development.regulatory_impact.show', $regulatoryImpact);
    }

    /**
     * Update dictamen (solo roles: des_Institucional, all).
     */
    public function updateDictamen(Request $request, RegulatoryImpact $regulatoryImpact)
    {
        if (! Auth::user()->hasAnyRole(['des_Institucional', 'all'])) {
            abort(403, 'No tienes permiso para dictaminar en este módulo.');
        }

        if (in_array($regulatoryImpact->dictamen_status, ['aprobado', 'rechazado'])) {
            // Solo se permite actualizar show_in_front en resoluciones finales
            $this->validate($request, ['show_in_front' => 'nullable|boolean']);
            $regulatoryImpact->update(['show_in_front' => $request->boolean('show_in_front')]);
            Session::flash('success', 'Visibilidad en el front actualizada.');
            return redirect()->route('institucional_development.regulatory_impact.show', $regulatoryImpact);
        }

        $this->validate($request, [
            'dictamen_status' => 'required|in:pendiente,rechazado,aprobado',
            'show_in_front'   => 'nullable|boolean',
            'dictamen_file'   => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'dictamen_status' => $request->dictamen_status,
            'show_in_front'   => $request->boolean('show_in_front'),
        ];

        if ($request->hasFile('dictamen_file')) {
            // Eliminar dictamen anterior si existe
            if ($regulatoryImpact->dictamen_file) {
                Storage::disk('s3')->delete($regulatoryImpact->dictamen_file);
            }

            $file  = $request->file('dictamen_file');
            $ext   = $file->getClientOriginalExtension();
            $path  = "regulatory_impact/dictamenes/{$regulatoryImpact->folio}.{$ext}";
            Storage::disk('s3')->put($path, file_get_contents($file));
            $data['dictamen_file']    = $path;
            $data['dictamen_s3_url']  = Storage::disk('s3')->url($path);
        }

        $regulatoryImpact->update($data);

        Session::flash('success', 'Dictamen actualizado exitosamente.');

        return redirect()->route('institucional_development.regulatory_impact.show', $regulatoryImpact);
    }
}

