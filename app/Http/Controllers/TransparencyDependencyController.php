<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TransparencyDependency;
use App\Models\TransparencyFile;

use Illuminate\Http\Request;

class TransparencyDependencyController extends Controller
{
    public function index()
    {
        $transparency_dependencies = TransparencyDependency::paginate(10);

        return view('transparency_dependencies.index')->with('transparency_dependencies', $transparency_dependencies);
    }

    public function create()
    {
        return view('transparency_dependencies.create');
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'in_index' => 'boolean',
        ]);

        // Subir archivos
        $logoPath = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : null;
        $imageCoverPath = $request->file('image_cover') ? $request->file('image_cover')->store('covers', 'public') : null;

        // Guardar datos en la base de datos
        $transparency_dependency = TransparencyDependency::create([
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $logoPath,
            'image_cover' => $imageCoverPath,
            'in_index' => $request->has('in_index') ? $request->in_index : false,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $transparency_dependency = TransparencyDependency::find($id);

        return view('transparency_dependencies.show')->with('transparency_dependency', $transparency_dependency);
    }

    public function edit($id)
    {
        $transparency_dependency = TransparencyDependency::find($id);

        return view('transparency_dependencies.edit')->with('transparency_dependency', $transparency_dependency);
    }

    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'in_index' => 'boolean',
        ]);

        $transparency_dependency = TransparencyDependency::find($id);

        // Subir archivos
        $logoPath = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : $transparency_dependency->logo;
        $imageCoverPath = $request->file('image_cover') ? $request->file('image_cover')->store('covers', 'public') : $transparency_dependency->image_cover;

        // Actualizar datos en la base de datos
        $transparency_dependency->update([
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $logoPath,
            'image_cover' => $imageCoverPath,
            'in_index' => $request->has('in_index') ? $request->in_index : false,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_dependency = TransparencyDependency::find($id);
        $transparency_dependency->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
