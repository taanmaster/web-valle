<?php

namespace App\Http\Controllers;

use Str;
use App\Models\EventsBlog;
use App\Models\EventsBlogImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class EventsBlogController extends Controller
{
    public function index()
    {
        return view('events-blog.index', [
            'entries' => EventsBlog::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        $mode = 0;

        return view('events-blog.create', [
            'mode' => $mode,
        ]);
    }

    public function show($id)
    {
        $entry = EventsBlog::findOrFail($id);
        $mode = 1;

        return view('events-blog.show', [
            'entry' => $entry,
            'mode'  => $mode,
        ]);
    }

    public function edit($id)
    {
        $entry = EventsBlog::findOrFail($id);
        $mode = 2;

        return view('events-blog.edit', [
            'entry' => $entry,
            'mode'  => $mode,
        ]);
    }

    public function destroy($id)
    {
        $entry = EventsBlog::findOrFail($id);
        $entry->delete();

        return redirect()->route('events_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function uploadFile(Request $request, $id)
    {
        $entry = EventsBlog::findOrFail($id);

        foreach ($request->file('file') as $file) {
            $filename = Str::random(8) . '_image.' . $file->getClientOriginalExtension();
            $location = public_path('images/events-blog/');
            $file->move($location, $filename);

            $image              = new EventsBlogImage();
            $image->events_blog_id = $entry->id;
            $image->image_path  = 'images/events-blog/' . $filename;
            $image->save();
        }

        return response()->json(['success' => $filename]);
    }

    public function fetchFile($id)
    {
        $entry = EventsBlog::find($id);

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

        $file = EventsBlogImage::where('image_path', 'like', '%' . $imageName)->first();

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

    public function frontIndex(Request $request)
    {
        $query = EventsBlog::where('is_active', true);

        if ($request->filled('fecha')) {
            $query->whereDate('published_at', $request->fecha);
        }
        if ($request->filled('categoria')) {
            $query->where('category', $request->categoria);
        }

        $entries = $query->latest()->paginate(8);

        return view('front.events_blog.index', compact('entries'));
    }

    public function frontShow($slug)
    {
        $entry = EventsBlog::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('front.events_blog.detail', compact('entry'));
    }
}
