<?php

namespace App\Http\Controllers;

class BlogCategoryController extends Controller
{
    public function index()
    {
        return view('blog-categories.index');
    }
}
