<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin', ['only' => ['destroy']]);
        $this->middleware('role:author,admin', ['only' => ['create', 'store', 'index', 'edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|string|min:5|unique:posts,title',
            'body' => 'required|min:20',
            'status' => 'required'
        ]);

        $request['published_at'] = $request->get('published_at') == null ? date("Y-m-d H:i:s") : $request->get('published_at');
        $request['slug'] = str_slug($request->get('title'), '-');

        Post::create($request->all());

        return redirect()->route('admin.posts.index');        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (Auth::user()->role == 'admin' || Auth::user()->id == $post->user_id) {
            return view('admin.post.edit', compact('post'));
        }
        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->role == 'admin' || Auth::user()->id == $post->user_id) {
            $this->validate($request, [
                'user_id' => 'required',
                'category_id' => 'required',
                'title' => 'required|string|min:5|unique:posts,title,' . $id,
                'body' => 'required|min:20',
                'status' => 'required'
            ]);
    
            $request['published_at'] = $request->get('published_at') == null ? date("Y-m-d H:i:s") : $request->get('published_at');
            $request['slug'] = str_slug($request->get('title'), '-');
    
            $post->update($request->all());
    
            return redirect()->route('admin.posts.index');
        }

        return abort(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Post::destroy($id)) return redirect()->back();

        return redirect()->route('admin.posts.index');
    }

    public function dataTable()
    {
        $posts = Post::query();
        return DataTables::of($posts)
            ->addColumn('title', function ($posts) {
                return substr($posts->title, 0, 30);
            })
            ->addColumn('author', function ($posts) {
                return $posts->user->name;
            })
            ->addColumn('category', function ($posts) {
                return $posts->category->title;
            })
            ->addColumn('published_at', function ($posts) {
                if (!$posts->published_at == null) {
                    setlocale(LC_TIME, config('app.locale'));
                    return \Carbon\Carbon::parse($posts->published_at)->formatLocalized('%A, %d %B %Y');
                }
                return;
            })
            ->addColumn('action', function ($posts) {
                return view('layouts.admin.partials._action', [
                    'model' => $posts,
                    'url_show' => route('admin.posts.show', $posts->id),
                    'url_edit' => route('admin.posts.edit', $posts->id),
                    'url_destroy' => route('admin.posts.destroy', $posts->id)
                ]);
            })
            ->rawColumns(['action'])->make(true);
    }
}
