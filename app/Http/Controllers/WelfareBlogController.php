<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\WelfareBlog;
use App\Models\WelfareBlogImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class WelfareBlogController extends Controller
{
    public function adminDetail($id)
    {
        $post = WelfareBlog::with('images')->findOrFail($id);

        return view('welfare.detail', compact('post'));
    }

    public function adminPage()
    {
        $posts = WelfareBlog::where('is_active', true)->latest('published_at')->get();

        return view('welfare.index')->with('posts', $posts);
    }

    public function index()
    {
        return view('welfare-blog.index', [
            'entries' => WelfareBlog::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('welfare-blog.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = WelfareBlog::findOrFail($id);

        return view('welfare-blog.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = WelfareBlog::findOrFail($id);

        return view('welfare-blog.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function destroy($id)
    {
        WelfareBlog::findOrFail($id)->delete();

        return redirect()->route('welfare_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function uploadFile(Request $request, $id)
    {
        $entry = WelfareBlog::findOrFail($id);

        foreach ($request->file('file') as $file) {
            $filename = Str::random(8) . '_image.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/welfare-blog/'), $filename);

            WelfareBlogImage::create([
                'welfare_blog_id' => $entry->id,
                'image_path'      => 'images/welfare-blog/' . $filename,
            ]);
        }

        return response()->json(['success' => $filename]);
    }

    public function fetchFile($id)
    {
        $entry  = WelfareBlog::find($id);
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
        $file      = WelfareBlogImage::where('image_path', 'like', '%' . $imageName)->first();

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

    // ── Vista pública ──────────────────────────────────────────────────────────
    public function frontShow($slug)
    {
        $entry = WelfareBlog::where('slug', $slug)->firstOrFail();

        return view('welfare-blog.show', ['entry' => $entry, 'mode' => 1]);
    }
}
