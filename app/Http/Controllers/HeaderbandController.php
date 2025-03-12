<?php

namespace App\Http\Controllers;

use Str;
use Auth;
use Image;
use Session;

use App\Models\Headerband;

use Illuminate\Http\Request;

class HeaderbandController extends Controller
{
    public function index()
    {
        $headerbands = Headerband::paginate(5);

        return view('headerbands.index', compact('headerbands'));
    }

    public function create()
    {
        return view('headerbands.create');
    }

    public function store(Request $request)
    {
        //Validar
        $request->validate([
            'title' => 'required|max:255',
            'text' => 'required|max:255',
        ]);

        // Guardar datos en la base de datos
        $headerband = new Headerband;

        $headerband->title = $request->title;
        $headerband->text= $request->text;
        $headerband->button_text= $request->button_text;
        $headerband->priority = $request->priority;
        $headerband->hex_text = $request->hex_text;
        $headerband->hex_button_text = $request->hex_button_text;
        $headerband->hex_button_back = $request->hex_button_back;
        $headerband->band_link = $request->band_link;
        $headerband->is_active = true;
        $headerband->hex_background = $request->hex_background;
        $headerband->save();

        // Mensaje de session
        Session::flash('success', 'Se creó el cintillo con exito.');

        // Enviar a vista
        return redirect()->route('headerbands.index');
    }

    public function show($id)
    {
        $headerband = Headerband::find($id);

        return view('headerbands.show')->with('headerband', $headerband);
    }


    public function edit($id)
    {
        $headerband = Headerband::find($id);

        return view('headerbands.edit')->with('headerband', $headerband);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $request->validate([
            'title' => 'required|max:255',
            'text' => 'required|max:255',
        ]);

        // Guardar datos en la base de datos
        $headerband = Headerband::find($id);

        $headerband->title = $request->title;
        $headerband->text= $request->text;
        $headerband->button_text= $request->button_text;
        $headerband->priority = $request->priority;
        $headerband->hex_text = $request->hex_text;
        $headerband->hex_button_text = $request->hex_button_text;
        $headerband->hex_button_back = $request->hex_button_back;
        $headerband->band_link = $request->band_link;
        $headerband->hex_background = $request->hex_background;
        
        $headerband->save();

        // Mensaje de session
        Session::flash('success', 'Se actualizó la información del cintillo con exito.');

        // Enviar a vista
        return redirect()->route('headerbands.index');
    }

    public function status(Request $request)
    {
        // Guardar datos en la base de datos
        $headerband = Headerband::find($request->id);

        if($headerband->is_active == true) {
            $headerband->is_active = false;
        }else {
            $headerband->is_active = true;
        }
        $headerband->save();

        // Mensaje de session
        Session::flash('success', 'El cintillo se ha cambiado de estado.');

        // Enviar a vista
        return redirect()->route('headerbands.index');
    }

    public function destroy($id)
    {
        $headerband = Headerband::find($id);
        $headerband->delete();

        Session::flash('success', 'El cintillo se eliminó correctamente.');

        return redirect()->route('headerbands.index');
    }
}
