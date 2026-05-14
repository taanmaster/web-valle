<?php

namespace App\Http\Controllers;

use App\Models\GeneralBlog;
use Illuminate\Http\Request;

class EventsBlogController extends Controller
{
    public function index()
    {
        return view('events-blog.index', [
            'entries' => GeneralBlog::where('type', 'events')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('events-blog.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = GeneralBlog::where('type', 'events')->findOrFail($id);

        return view('events-blog.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = GeneralBlog::where('type', 'events')->findOrFail($id);

        return view('events-blog.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function adminDetail($id)
    {
        $entry = GeneralBlog::where('type', 'events')
            ->with('images')
            ->findOrFail($id);

        return view('events-blog.detail', compact('entry'));
    }

    public function destroy($id)
    {
        GeneralBlog::where('type', 'events')->findOrFail($id)->delete();

        return redirect()->route('events_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function frontIndex(Request $request)
    {
        $query = GeneralBlog::where('type', 'events')->where('is_active', true);

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
        $entry = GeneralBlog::where('type', 'events')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('front.events_blog.detail', compact('entry'));
    }
}
