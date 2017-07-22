<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function add()
    {
        return view('admin/article/add');
    }

    public function index()
    {
        return view('admin/article/index');
    }
}
