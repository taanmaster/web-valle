<?php

namespace App\Http\Controllers;

use App\Models\GeneralBlog;

class EnvironmentBlogController extends Controller
{
    /**
     * Blog de la Dirección de Medio Ambiente. El front público ya lo sirve
     * desde FrontController@environment* (mismo type, mismas tablas); este
     * controlador sólo cubre el backoffice.
     */
    private const TYPE = GeneralBlog::TYPE_MEDIO_AMBIENTE;

    public function index()
    {
        return view('environment-blog.index', [
            'entries' => GeneralBlog::where('type', self::TYPE)->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('environment-blog.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = GeneralBlog::where('type', self::TYPE)->findOrFail($id);

        return view('environment-blog.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = GeneralBlog::where('type', self::TYPE)->findOrFail($id);

        return view('environment-blog.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function adminDetail($id)
    {
        $entry = GeneralBlog::where('type', self::TYPE)->with('images')->findOrFail($id);

        return view('environment-blog.detail', compact('entry'));
    }

    public function destroy($id)
    {
        GeneralBlog::where('type', self::TYPE)->findOrFail($id)->delete();

        return redirect()->route('medio_ambiente_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }
}
