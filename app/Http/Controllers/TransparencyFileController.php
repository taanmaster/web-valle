<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TransparencyFile;
use App\Models\TransparencyDependency;

use Illuminate\Http\Request;

class TransparencyFileController extends Controller
{
    public function index()
    {
        $transparency_files = TransparencyFile::paginate(10);

        return view('transparency_files.index')->with('transparency_files', $transparency_files);
    }

    public function create()
    {
        return view('transparency_files.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $transparency_file = TransparencyFile::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $transparency_file = TransparencyFile::find($id);

        return view('transparency_files.show')->with('transparency_file', $transparency_file);
    }

    public function edit($id)
    {
        $transparency_file = TransparencyFile::find($id);

        return view('transparency_files.edit')->with('transparency_file', $transparency_file);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $transparency_file = TransparencyFile::find($id);

        $transparency_file->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_file = TransparencyFile::find($id);
        $transparency_file->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }

    function uploadFile(Request $request, $id)
    {   
        $dependency = TransparencyDependency::find($id);

        // Guardar datos en la base de datos
        $var_file = new TransparencyFile;
        $var_file->dependency_id = $dependency->id;

        $file = $request->file('file');
        $filename = $dependency->name . '_' . Str::random(8) . '_file' . '.' . $file->getClientOriginalExtension();
        $location = public_path('files/transparency/');
        $file->move($location, $filename);

        $var_file->permalink = $location . $filename;
        $var_file->name = $filename;
        $var_file->filename = $filename;
        $var_file->file_extension = $file->getClientOriginalExtension();
        $var_file->uploaded_by = Auth::user()->id;

        $var_file->save();
        
        return response()->json(['success' => $filename]);
    }

    function fetchFile($id)
    {
        $dependency = TransparencyDependency::find($id);
        
        $output = '<div class="row">';
        foreach($dependency->files as $file)
        {
            $icon = 'fa-file';
            $badge = '';
            $publicPath = url('files/transparency/' . $file->filename);

            switch ($file->file_extension) {
                case 'pdf':
                    $icon = 'fa-file-pdf';
                    $badge = 'PDF';
                    break;
                case 'doc':
                case 'docx':
                    $icon = 'fa-file-word';
                    $badge = 'Word';
                    break;
                case 'xls':
                case 'xlsx':
                    $icon = 'fa-file-excel';
                    $badge = 'Excel';
                    break;
                case 'ppt':
                case 'pptx':
                    $icon = 'fa-file-powerpoint';
                    $badge = 'PowerPoint';
                    break;
                case 'txt':
                    $icon = 'fa-file-alt';
                    $badge = 'Texto';
                    break;
                case 'zip':
                case 'rar':
                    $icon = 'fa-file-archive';
                    $badge = 'Archivo';
                    break;
                default:
                    $icon = 'fa-file';
                    $badge = 'Archivo';
                    break;
            }

            $output .= '
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas '.$icon.' fa-3x"></i>
                        <h5 class="card-title mt-2">'.$file->name.'</h5>
                        <span class="badge bg-primary">'.$badge.'</span>
                        <input type="text" class="form-control mt-2" id="filePath'.$file->id.'" value="'.$publicPath.'" readonly>
                        <button type="button" class="btn btn-outline-primary mt-2" onclick="copyToClipboard(\'filePath'.$file->id.'\')">Copiar Ruta</button>
                        <button type="button" class="btn btn-link remove_file mt-2" id="'.$file->filename.'">Eliminar</button>
                    </div>
                </div>
            </div>
            ';
        }
        $output .= '</div>';

        echo $output;
    }

    function deleteFile(Request $request)
    {
        $file = TransparencyFile::where('filename', $request->name)->first();
        
        if ($file) {
            // Eliminar el archivo de la base de datos
            $file->delete();

            // Eliminar el archivo del sistema de archivos
            $filePath = public_path('files/transparency/' . $request->name);
            if (\File::exists($filePath)) {
                \File::delete($filePath);
            }

            return response()->json(['success' => 'Archivo eliminado correctamente.']);
        }

        return response()->json(['error' => 'Archivo no encontrado.'], 404);
    }
}
