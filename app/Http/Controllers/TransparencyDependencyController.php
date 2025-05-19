<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Intervention\Image\Facades\Image as Image;

// Modelos
use App\Models\TransparencyDependency;
use App\Models\TransparencyFile;
use App\Models\User;

use Illuminate\Http\Request;

class TransparencyDependencyController extends Controller
{
    public function index()
    {
        $transparency_dependencies = TransparencyDependency::where('belongs_to_treasury', false)->paginate(10);

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
            'belongs_to_treasury' => 'boolean',
        ]);

        // Subir archivos
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo');
            $logoName = Str::random(8) . '_logo' . '.' . $logoPath->getClientOriginalExtension();
            $logoLocation = public_path('images/dependencies/' . $logoName);
            Image::make($logoPath)->resize(960, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($logoLocation);
        }

        if ($request->hasFile('image_cover')) {
            $imageCoverPath = $request->file('image_cover');
            $imageCoverName = Str::random(8) . '_cover' . '.' . $imageCoverPath->getClientOriginalExtension();
            $imageCoverLocation = public_path('images/dependencies/' . $imageCoverName);
            Image::make($imageCoverPath)->resize(960, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($imageCoverLocation);
        }

        // Guardar datos en la base de datos
        $transparency_dependency = TransparencyDependency::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'logo' => $logoName ?? null,
            'image_cover' => $imageCoverName ?? null,
            'in_index' => $request->in_index ?? false,
            'belongs_to_treasury' => $request->belongs_to_treasury ?? false,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $transparency_dependency = TransparencyDependency::find($id);
        $users = User::all();

        return view('transparency_dependencies.show')
            ->with('transparency_dependency', $transparency_dependency)
            ->with('users', $users);
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
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo');
            $logoName = Str::random(8) . '_logo' . '.' . $logoPath->getClientOriginalExtension();
            $logoLocation = public_path('images/dependencies/' . $logoName);
            Image::make($logoPath)->resize(960, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($logoLocation);
            $transparency_dependency->logo = $logoName;
        }

        if ($request->hasFile('image_cover')) {
            $imageCoverPath = $request->file('image_cover');
            $imageCoverName = Str::random(8) . '_cover' . '.' . $imageCoverPath->getClientOriginalExtension();
            $imageCoverLocation = public_path('images/dependencies/' . $imageCoverName);
            Image::make($imageCoverPath)->resize(960, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($imageCoverLocation);
            $transparency_dependency->image_cover = $imageCoverName;
        }

        // Actualizar datos en la base de datos
        $transparency_dependency->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'in_index' => $request->in_index ?? false,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista

        if ($transparency_dependency->belongs_to_treasury == true) {
            return redirect()->route('treasury_dependencies.index');
        } else {
            return redirect()->route('transparency_dependencies.index');
        }
    }

    public function destroy($id)
    {
        $transparency_dependency = TransparencyDependency::find($id);

        // Eliminar documentos de las obligaciones
        $transparency_dependency->obligations->each(function ($obligation) {
            $obligation->documents->each(function ($document) {
                // Eliminar el archivo del sistema de archivos
                if (\File::exists(public_path('files/transparency/' . $document->filename))) {
                    \File::delete(public_path('files/transparency/' . $document->filename));
                }
                $document->delete();
            });
        });

        // Eliminar archivos de repositorio
        $transparency_dependency->files->each(function ($file) {
            // Eliminar el archivo del sistema de archivos
            if (\File::exists(public_path('files/transparency/' . $file->filename))) {
                \File::delete(public_path('files/transparency/' . $file->filename));
            }
            $file->delete();
        });

        // Eliminar obligaciones
        $transparency_dependency->obligations->each(function ($obligation) {
            $obligation->delete();
        });

        // Eliminar asociaciones de usuario
        $transparency_dependency->users()->delete();

        // Eliminar la dependencia
        $transparency_dependency->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
