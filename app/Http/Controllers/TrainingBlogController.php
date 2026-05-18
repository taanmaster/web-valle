<?php

namespace App\Http\Controllers;

use App\Models\GeneralBlog;
use App\Models\TrainingDownloadable;
use Illuminate\Http\Request;

class TrainingBlogController extends Controller
{
    public function adminPage()
    {
        $posts = GeneralBlog::where('type', 'training')
            ->where('is_active', true)
            ->latest('published_at')
            ->get();

        $latestDownloadable = TrainingDownloadable::latest()->first();

        return view('training.index', compact('posts', 'latestDownloadable'));
    }

    public function adminDetail($id)
    {
        $post = GeneralBlog::where('type', 'training')
            ->with('images')
            ->findOrFail($id);

        return view('training.detail', compact('post'));
    }

    public function index()
    {
        return view('training-blog.index', [
            'entries' => GeneralBlog::where('type', 'training')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('training-blog.create', ['mode' => 0]);
    }

    public function show($id)
    {
        $entry = GeneralBlog::where('type', 'training')->findOrFail($id);

        return view('training-blog.show', ['entry' => $entry, 'mode' => 1]);
    }

    public function edit($id)
    {
        $entry = GeneralBlog::where('type', 'training')->findOrFail($id);

        return view('training-blog.edit', ['entry' => $entry, 'mode' => 2]);
    }

    public function destroy($id)
    {
        GeneralBlog::where('type', 'training')->findOrFail($id)->delete();

        return redirect()->route('training_blog.admin.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }
}
