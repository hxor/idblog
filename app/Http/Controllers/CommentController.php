<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CommentController extends Controller
{
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
