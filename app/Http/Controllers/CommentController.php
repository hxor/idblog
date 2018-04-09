<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.comment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comment.edit', compact('comment'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'body' => 'required',
            'status' => 'required'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        return redirect()->route('admin.comments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Comment::destroy($id)) return redirect()->back();

        return redirect()->route('admin.comments.index');
    }

    public function dataTable()
    {
        $comments = Comment::query();
        return DataTables::of($comments)
            ->addColumn('comment', function ($comment) {
                return substr($comment->body, 0, 30);
            })
            ->addColumn('post', function ($comment) {
                return substr($comment->post->title, 0, 30);
            })
            ->addColumn('status', function ($comment) {
                return $comment->status == 0 ? 'Draft' : 'Published';
            })
            ->addColumn('action', function ($comment) {
                return view('layouts.admin.partials._action', [
                    'model' => $comment,
                    'url_show' => route('admin.comments.show', $comment->id),
                    'url_edit' => route('admin.comments.edit', $comment->id),
                    'url_destroy' => route('admin.comments.destroy', $comment->id)
                ]);
            })
            ->rawColumns(['action'])->make(true);
    }
}
