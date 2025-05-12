<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('blog.index', [
            'blogs' => Blog::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0;

        return view('blog.create', [
            'mode' => $mode,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        $mode = 1;

        return view('blog.show', [
            'blog' => $blog,
            'mode' => $mode,
        ]);
    }

    /**e
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        $mode = 2;

        return view('blog.edit', [
            'blog' => $blog,
            'mode' => $mode,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    function uploadFile(Request $request, $id)
    {
        $blog = Blog::find($id);

        // Guardar datos en la base de datos
        $var_file = new BlogImage();
        $var_file->blog_id = $blog->id;

        $file = $request->file('file');
        $filename = $blog->name . '_' . Str::random(8) . '_file' . '.' . $file->getClientOriginalExtension();
        $location = public_path('files/blog/');
        $file->move($location, $filename);

        $var_file->image_path = $location . $filename;
        $var_file->save();

        return response()->json(['success' => $filename]);
    }

    function fetchFile($id)
    {
        $blog = Blog::find($id);

        $output = '<div class="row">';
        foreach ($blog->files as $file) {
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
                        <i class="fas ' . $icon . ' fa-3x"></i>
                        <h5 class="card-title mt-2">' . $file->name . '</h5>
                        <span class="badge bg-primary">' . $badge . '</span>
                        <input type="text" class="form-control mt-2" id="filePath' . $file->id . '" value="' . $publicPath . '" readonly>
                        <button type="button" class="btn btn-outline-primary mt-2" onclick="copyToClipboard(\'filePath' . $file->id . '\')">Copiar Ruta</button>
                        <button type="button" class="btn btn-link remove_file mt-2" id="' . $file->filename . '">Eliminar</button>
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
        $file = BlogImage::where('image_path', $request->name)->first();

        if ($file) {
            // Eliminar el archivo de la base de datos
            $file->delete();

            // Eliminar el archivo del sistema de archivos
            $filePath = public_path('files/blog/' . $request->name);
            if (\File::exists($filePath)) {
                \File::delete($filePath);
            }

            return response()->json(['success' => 'Archivo eliminado correctamente.']);
        }

        return response()->json(['error' => 'Archivo no encontrado.'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blog.admin.index')->with('success', 'Blog eliminado correctamente.');
    }
}
