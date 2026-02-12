<?php

namespace App\Http\Controllers;

use Str;
use Auth;
use Session;
use Carbon\Carbon;

use App\Models\TourismBlog;
use App\Models\TourismBlogImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class TourismBlogController extends Controller
{
    public function index()
    {
        return view('tourism.blog.index', [
            'blogs' => TourismBlog::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        $mode = 0;

        return view('tourism.blog.create', [
            'mode' => $mode,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $blog = TourismBlog::findOrFail($id);

        $mode = 1;

        return view('tourism.blog.show', [
            'blog' => $blog,
            'mode' => $mode,
        ]);
    }

    public function edit($id)
    {
        $blog = TourismBlog::findOrFail($id);

        $mode = 2;

        return view('tourism.blog.edit', [
            'blog' => $blog,
            'mode' => $mode,
        ]);
    }

    public function update(Request $request, TourismBlog $tourismBlog)
    {
        //
    }

    public function uploadFile(Request $request, $id)
    {
        $blog = TourismBlog::findOrFail($id);

        foreach ($request->file('file') as $file) {
            $filename = Str::random(8) . '_image.' . $file->getClientOriginalExtension();
            $location = public_path('images/tourism/blog/');
            $file->move($location, $filename);

            $var_file = new TourismBlogImage();
            $var_file->tourism_blog_id = $blog->id;
            $var_file->image_path = 'images/tourism/blog/' . $filename;
            $var_file->save();
        }

        return response()->json(['success' => $filename]);
    }

    function fetchFile($id)
    {
        $blog = TourismBlog::find($id);

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

        $file = TourismBlogImage::where('image_path', 'like', '%' . $imageName)->first();

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

    public function destroy($id)
    {
        $blog = TourismBlog::findOrFail($id);
        $blog->delete();

        return redirect()->route('tourism.blog.admin.index')->with('success', 'Blog eliminado correctamente.');
    }
}
