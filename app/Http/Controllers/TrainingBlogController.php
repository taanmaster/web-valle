<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\TrainingBlog;
use App\Models\TrainingBlogImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class TrainingBlogController extends Controller
{
    public function adminPage()
    {
        $posts = TrainingBlog::where('is_active', true)->latest('published_at')->get();

        return view('training.index', compact('posts'));
    }

    public function adminDetail($id)
    {
        $post = TrainingBlog::with('images')->findOrFail($id);

        return view('training.detail', compact('post'));
    }

    public function index()
    {
        return view('training-blog.index', [
            'entries' => TrainingBlog::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('training-blog.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = TrainingBlog::findOrFail($id);

        return view('training-blog.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = TrainingBlog::findOrFail($id);

        return view('training-blog.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function destroy($id)
    {
        TrainingBlog::findOrFail($id)->delete();

        return redirect()->route('training_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function uploadFile(Request $request, $id)
    {
        $entry = TrainingBlog::findOrFail($id);

        foreach ($request->file('file') as $file) {
            $filename = Str::random(8) . '_image.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/training-blog/'), $filename);

            TrainingBlogImage::create([
                'training_blog_id' => $entry->id,
                'image_path'       => 'images/training-blog/' . $filename,
            ]);
        }

        return response()->json(['success' => $filename]);
    }

    public function fetchFile($id)
    {
        $entry  = TrainingBlog::find($id);
        $output = '<div class="row">';

        foreach ($entry->images as $file) {
            $publicPath = url($file->image_path);
            $output .= '
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-file fa-3x"></i>
                        <h5 class="card-title mt-2">' . $file->image_path . '</h5>
                        <span class="badge bg-primary">Imagen</span>
                        <input type="text" class="form-control mt-2" value="' . $publicPath . '" readonly>
                        <button type="button" class="btn btn-link remove_file mt-2" id="' . $file->image_path . '">Eliminar</button>
                    </div>
                </div>
            </div>';
        }

        $output .= '</div>';
        echo $output;
    }

    public function deleteFile(Request $request)
    {
        $imageName = $request->image_path;
        $file      = TrainingBlogImage::where('image_path', 'like', '%' . $imageName)->first();

        if ($file) {
            $filePath = public_path($imageName);
            if (\File::exists($filePath)) {
                \File::delete($filePath);
            }
            $file->delete();

            return response()->json(['success' => 'Archivo eliminado correctamente.']);
        }

        return response()->json(['error' => 'Archivo no encontrado.'], 404);
    }
}
