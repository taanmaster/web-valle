<?php

namespace App\Http\Controllers;

use App\Models\GeneralBlog;
use Illuminate\Http\Request;

class WelfareBlogController extends Controller
{
    public function adminPage()
    {
        $posts = GeneralBlog::where('type', 'welfare')
            ->where('is_active', true)
            ->latest('published_at')
            ->get();

        return view('welfare.index', compact('posts'));
    }

    public function adminDetail($id)
    {
        $post = GeneralBlog::where('type', 'welfare')
            ->with('images')
            ->findOrFail($id);

        return view('welfare.detail', compact('post'));
    }

    public function index()
    {
        return view('welfare-blog.index', [
            'entries' => GeneralBlog::where('type', 'welfare')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('welfare-blog.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = GeneralBlog::where('type', 'welfare')->findOrFail($id);

        return view('welfare-blog.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = GeneralBlog::where('type', 'welfare')->findOrFail($id);

        return view('welfare-blog.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function destroy($id)
    {
        GeneralBlog::where('type', 'welfare')->findOrFail($id)->delete();

        return redirect()->route('welfare_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function frontShow($slug)
    {
        $entry = GeneralBlog::where('type', 'welfare')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('welfare-blog.show', ['entry' => $entry, 'mode' => 1]);
    }
}
