<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $users = User::query();
        return DataTables::of($users)
            ->addColumn('user', function ($users) {
                return '<img src="image/user-icon.png" height="32" width="32"> ' . $users->name;
            })
            ->addColumn('action', function ($users) {
                return '
                    <button type="button" class="btn btn-sm btn-outline-info" style="padding-bottom: 0px; padding-top: 0px;">
                    Show
                    <span class="btn-label btn-label-right"><i class="fa fa-eye"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" style="padding-bottom: 0px; padding-top: 0px;">
                        Edit
                        <span class="btn-label btn-label-right"><i class="fa fa-edit"></i></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" style="padding-bottom: 0px; padding-top: 0px;">
                        Show
                        <span class="btn-label btn-label-right"><i class="fa fa-trash"></i></span>
                    </button>
                ';
            })
            ->rawColumns(['user', 'action'])->make(true);
    }
}
