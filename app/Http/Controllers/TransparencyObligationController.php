<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Image;

// Modelos
use App\Models\TransparencyObligation;
use App\Models\TransparencyDependency;

use Illuminate\Http\Request;

class TransparencyObligationController extends Controller
{
    public function index()
    {
        $transparency_obligations = TransparencyObligation::paginate(10);
        $transparency_dependencies = TransparencyDependency::all();

        return view('transparency_obligations.index')
        ->with('transparency_obligations', $transparency_obligations)
        ->with('transparency_dependencies', $transparency_dependencies);
    }

    public function create()
    {
        return view('transparency_obligations.create');
    }

    public function store(Request $request)
    {
        // Validación de datos
        $this->validate($request, [
            'name' => 'required|max:255',
            'dependency_id' => 'required|integer',
            'type' => 'required|string',
            'update_period' => 'required|string',
            'icon' => 'nullable|image|mimes:png|max:2048', // solo PNG
        ]);

        // Crear instancia del modelo
        $transparency_obligation = new TransparencyObligation();
        $transparency_obligation->name = $request->name;
        $transparency_obligation->slug = Str::slug($request->name);
        $transparency_obligation->description = $request->description;
        $transparency_obligation->dependency_id = $request->dependency_id;
        $transparency_obligation->type = $request->type;
        $transparency_obligation->update_period = $request->update_period;

        // Manejar la imagen (icon)
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $filename = 'icon_' . time() . '.png'; // forzamos extensión .png
            $location = public_path('front/img/icons/' . $filename);

            // Redimensionar y guardar como PNG
            Image::make($image)
                ->resize(1280, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('png', 100)
                ->save($location);

            $transparency_obligation->icon = $filename;
        }

        // Guardar registro
        $transparency_obligation->save();

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $transparency_obligation = TransparencyObligation::find($id);

        return view('transparency_obligations.show')->with('transparency_obligation', $transparency_obligation);
    }

    public function edit($id)
    {
        $transparency_obligation = TransparencyObligation::find($id);

        return view('transparency_obligations.edit')->with('transparency_obligation', $transparency_obligation);
    }

    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'type' => 'required|string',
            'update_period' => 'required|string',
            'icon' => 'nullable|image|mimes:png|max:2048', // solo PNG
        ]);

        $transparency_obligation = TransparencyObligation::findOrFail($id);

        // Actualizar campos básicos
        $transparency_obligation->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'type' => $request->type,
            'update_period' => $request->update_period,
        ]);

        // Manejar el nuevo icono (si se envió)
        if ($request->hasFile('icon')) {
            // Eliminar icono anterior si existe
            if ($transparency_obligation->icon && file_exists(public_path('front/img/icons/' . $transparency_obligation->icon))) {
                unlink(public_path('front/img/icons/' . $transparency_obligation->icon));
            }

            // Subir nuevo icono
            $image = $request->file('icon');
            $filename = 'icon_' . time() . '.png';
            $location = public_path('front/img/icons/' . $filename);

            Image::make($image)
                ->resize(1280, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('png', 100)
                ->save($location);

            $transparency_obligation->icon = $filename;
            $transparency_obligation->save();
        }

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_obligation = TransparencyObligation::find($id);
        $transparency_obligation->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
