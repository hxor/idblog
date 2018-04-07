<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
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

    public function blog()
    {
        $setting = $this->setting();
        $posts = Post::where('status', 1)->orderBy('published_at', 'DESC')->paginate(4);
        return view('blog', compact('setting', 'posts'));
    }

    public function show($slug)
    {
        $setting = $this->setting();
        $post = Post::where('slug', $slug)->first();

        // get previous post from $post data
        $prev = Post::where('id', '<', $post->id)
            ->latest('id')
            ->first();

        // get next post from $post data
        $next = Post::where('id', '>', $post->id)
            ->first();

        return view('show', compact('setting', 'post', 'prev', 'next'));
    }

    public function comment(Request $request, $slug)
    {
        $this->validate($request, [
            'post_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'body' => 'required'
        ]);

        $request['status'] = 0;
        Comment::create($request->all());

        return redirect('/blog/' . $slug);
    }
}
