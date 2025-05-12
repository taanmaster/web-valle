<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('blog.index', [
            'blogs' => Blog::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mode = 0;

        return view('blog.create', [
            'mode' => $mode,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        $mode = 1;

        return view('blog.show', [
            'blog' => $blog,
            'mode' => $mode,
        ]);
    }

    /**e
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        $mode = 2;

        return view('blog.edit', [
            'blog' => $blog,
            'mode' => $mode,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blog.admin.index')->with('success', 'Blog eliminado correctamente.');
    }
}
