<?php

namespace App\Http\Controllers;

use App\Models\ImplanBlog;
use Illuminate\Http\Request;

class ImplanBlogController extends Controller
{
    public function index()
    {
        $posts = ImplanBlog::get();

        return view('implan.blog.index')->with('posts', $posts);
    }

    public function create()
    {
        $mode = 0;

        return view('implan.blog.create')->with('mode', $mode);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $blog = ImplanBlog::findOrFail($id);

        $mode = 1;

        return view('implan.blog.show')->with([
            'blog' => $blog,
            'mode' => $mode
        ]);
    }

    public function edit($id)
    {
        $blog = ImplanBlog::findOrFail($id);

        $mode = 2;

        return view('implan.blog.edit')->with([
            'blog' => $blog,
            'mode' => $mode
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImplanBlog $implanBlog)
    {
        //
    }

    public function destroy($id)
    {
        $blog = ImplanBlog::findOrFail($id);
        $blog->delete();

        return redirect()->route('implan.blog.index')->with('success', 'Blog eliminado correctamente');
    }
}
