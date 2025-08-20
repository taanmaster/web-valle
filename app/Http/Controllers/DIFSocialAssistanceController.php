<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Str;

// Modelos
use App\Models\DIFSocialAssistance as SocialAssistance;

use Illuminate\Http\Request;

class DIFSocialAssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = SocialAssistance::query();

        if (request('search')) {
            $s = request('search');
            $query->where('name', 'LIKE', "%{$s}%")
                  ->orWhere('description', 'LIKE', "%{$s}%")
                  ->orWhere('value', 'LIKE', "%{$s}%");
        }

        $assistances = $query->paginate(30);

        return view('dif.social_assistances.index', compact('assistances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dif.social_assistances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_active' => 'nullable|boolean',
            'value' => 'nullable|max:255'
        ]);

        $data = $request->only(['name','description','value']);
        $data['is_active'] = $request->has('is_active');

        $assistance = SocialAssistance::create($data);

        Session::flash('success', 'Apoyo social creado correctamente.');

        return redirect()->route('dif.social_assistances.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $assistance = SocialAssistance::findOrFail($id);
        return view('dif.social_assistances.show', compact('assistance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assistance = SocialAssistance::findOrFail($id);
        return view('dif.social_assistances.edit', compact('assistance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_active' => 'nullable|boolean',
            'value' => 'nullable|max:255'
        ]);

        $assistance = SocialAssistance::findOrFail($id);

        $data = $request->only(['name','description','value']);
        $data['is_active'] = $request->has('is_active');

        $assistance->update($data);

        Session::flash('success', 'Apoyo social actualizado correctamente.');

        return redirect()->route('dif.social_assistances.show', $assistance->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assistance = SocialAssistance::findOrFail($id);
        $assistance->delete();

        Session::flash('success', 'Apoyo social eliminado de manera exitosa.');
        return redirect()->route('dif.social_assistances.index');
    }
}
