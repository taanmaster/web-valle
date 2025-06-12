<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image as Image;

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

    public function uploadFile(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        foreach ($request->file('file') as $file) {
            $filename = Str::random(8) . '_image.' . $file->getClientOriginalExtension();
            $location = public_path('images/blog/');
            $file->move($location, $filename);

            $var_file = new BlogImage();
            $var_file->blog_id = $blog->id;
            $var_file->image_path = 'images/blog/' . $filename;
            $var_file->save();
        }

        return response()->json(['success' => $filename]);
    }

    function fetchFile($id)
    {
        $blog = Blog::find($id);

        $output = '<div class="row">';
        foreach ($blog->images as $file) {
            $publicPath = url($file->image_path);

            $icon = 'fa-file';
            $badge = 'Archivo';

            $output .= '
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas ' . $icon . ' fa-3x"></i>
                        <h5 class="card-title mt-2">' . $file->image_path . '</h5>
                        <span class="badge bg-primary">' . $badge . '</span>
                        <input type="text" class="form-control mt-2" id="filePath' . $file->id . '" value="' . $publicPath . '" readonly>
                        <button type="button" class="btn btn-link remove_file mt-2" id="' . $file->image_path . '">Eliminar</button>
                    </div>
                </div>
            </div>
            ';
        }
        $output .= '</div>';

        echo $output;
    }

    public function deleteFile(Request $request)
    {
        $imageName = $request->image_path;

        // Busca el archivo solo por el nombre
        $file = BlogImage::where('image_path', 'like', '%' . $imageName)->first();

        if ($file) {
            // Eliminar archivo físico
            $filePath = public_path('images/blog/' . $imageName);
            if (\File::exists($filePath)) {
                \File::delete($filePath);
            }

            // Eliminar registro en base de datos
            $file->delete();

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
