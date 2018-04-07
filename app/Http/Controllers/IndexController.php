<?php

namespace App\Http\Controllers;

use App\Post;
use App\Setting;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function setting()
    {
        return Setting::first();
    }
    
    public function index()
    {
        $setting = $this->setting();
        $posts = Post::where('status', 1)->orderBy('published_at', 'DESC')->limit(3)->get();
        return view('welcome', compact('posts', 'setting'));
    }
}
