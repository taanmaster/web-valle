<?php

namespace App\Http\Controllers;

use Str;
use Auth;
use Image;
use Session;

use App\Models\DifBanner;
use Illuminate\Http\Request;

class DifBannerController extends Controller
{
    public function index()
    {
        $banners = DifBanner::orderBy('priority', 'asc')->paginate(5);

        return view('dif.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dif.banners.create');
    }

    public function store(Request $request)
    {
        //Validar
        $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable',
        ]);

        // Guardar datos en la base de datos
        $banner = new DifBanner;

        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->text_button = $request->text_button;
        $banner->link = $request->link;
        $banner->has_button = true;
        $banner->is_active = true;
        $banner->hex_text_title = $request->hex_text_title;
        $banner->hex_text_subtitle = $request->hex_text_subtitle;
        $banner->hex_button = $request->hex_button;
        $banner->hex_text_button = $request->hex_text_button;
        $banner->position = $request->position;
        $banner->priority = $request->priority;
        $banner->is_promotional = $request->is_promotional;

        // Video en Banner
        $banner->video_background = $request->video_background;
        $banner->video_autoplay = $request->video_autoplay;
        $banner->video_controls = $request->video_controls;
        $banner->video_loop = $request->video_loop;

        if (isset($request->video_background)) {
            $banner->image = 'N/A';
            $banner->image_responsive = 'N/A';
        }

        $img2 = 'banner';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'bannerdesktop' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('front/img/banners/' . $filename);

            Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);

            $banner->image = $filename;
        }

        // Imagen responsiva en Banner
        if ($request->hasFile('image_responsive')) {
            $image = $request->file('image_responsive');
            $filename = 'bannerresponsive' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('front/img/banners/' . $filename);

            Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);
            $banner->image_responsive = $filename;
        }

        $banner->save();

        // Mensaje de session
        Session::flash('success', 'Se creo el banner con exito.');

        // Enviar a vista
        return redirect()->route('dif.banners.show', $banner->id);
    }

    public function show($id)
    {
        $banner = DifBanner::find($id);

        return view('dif.banners.show')->with('banner', $banner);
    }

    public function edit($id)
    {
        $banner = DifBanner::find($id);

        return view('dif.banners.edit')->with('banner', $banner);
    }

    public function update(Request $request, $id)
    {
        // Guardar datos en la base de datos
        $banner = DifBanner::find($id);

        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->text_button = $request->text_button;
        $banner->link = $request->link;
        $banner->has_button = true;
        $banner->is_active = true;
        $banner->hex_text_title = $request->hex_text_title;
        $banner->hex_text_subtitle = $request->hex_text_subtitle;
        $banner->hex_button = $request->hex_button;
        $banner->hex_text_button = $request->hex_text_button;
        $banner->position = $request->position;
        $banner->priority = $request->priority;
        $banner->is_promotional = $request->is_promotional;

        // Video en Banner
        $banner->video_background = $request->video_background;
        $banner->video_autoplay = $request->video_autoplay;
        $banner->video_controls = $request->video_controls;
        $banner->video_loop = $request->video_loop;

        if (isset($request->video_background)) {
            $banner->image = 'N/A';
            $banner->image_responsive = 'N/A';
        }

        $img2 = 'model';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'bannerdesktop' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('front/img/banners/' . $filename);

            Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);

            $banner->image = $filename;
        }

        // Imagen responsiva en Banner
        if ($request->hasFile('image_responsive')) {
            $image = $request->file('image_responsive');
            $filename = 'bannerresponsive' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('front/img/banners/' . $filename);

            Image::make($image)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);
            $banner->image_responsive = $filename;
        }

        $banner->save();

        // Mensaje de session
        Session::flash('success', 'El banner se ha editado satisfactoriamente.');

        // Enviar a vista
        return redirect()->route('dif.banners.show', $banner->id);
    }

    public function status(Request $request)
    {
        // Guardar datos en la base de datos
        $banner = DifBanner::find($request->id);

        if ($banner->is_active == true) {
            $banner->is_active = false;
        } else {
            $banner->is_active = true;
        }

        $banner->save();

        // Mensaje de session
        Session::flash('success', 'El banner se ha cambiado de estado.');

        // Enviar a vista
        return redirect()->route('dif.banners.index');
    }

    public function destroy($id)
    {
        $banner = DifBanner::find($id);
        $banner->delete();

        Session::flash('success', 'El banner se elimino correctamente.');

        return redirect()->route('dif.banners.index');
    }
}
