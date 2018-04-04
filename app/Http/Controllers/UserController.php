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
        return view('admin.user.create');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required'
        ]);

        $request['password'] = bcrypt($request->get('password'));
        $request['avatar'] = $request->get('avatar') ? $request->get('avatar') : '/photos/user-icon.png';
        User::create($request->all());

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        $request['password'] = $request->get('password') ? bcrypt($request->get('password')) : $user->password;
        $request['avatar'] = $request->get('avatar') ? $request->get('avatar') : '/photos/user-icon.png';

        $user->update($request->all());

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!User::destroy($id)) return redirect()->back();

        return redirect()->route('admin.users.index');
    }

    public function dataTable()
    {
        $users = User::query();
        return DataTables::of($users)
            ->addColumn('user', function ($users) {
                return '<img src="' . asset($users->avatar) . '" height="32" width="32"> ' . $users->name;
            })
            ->addColumn('action', function ($users) {
                return '
                    <a href="' . route('admin.users.show', $users->id) . '" class="btn btn-sm btn-outline-info" style="padding-bottom: 0px; padding-top: 0px;">
                    Show
                    <span class="btn-label btn-label-right"><i class="fa fa-eye"></i></span>
                    </a>
                    <a href="' . route('admin.users.edit', $users->id) . '" class="btn btn-sm btn-outline-secondary" style="padding-bottom: 0px; padding-top: 0px;">
                        Edit
                        <span class="btn-label btn-label-right"><i class="fa fa-edit"></i></span>
                    </a>
                    <a  href="' . route('admin.users.destroy', $users->id) . '" 
                        class="btn btn-sm btn-outline-danger" 
                        style="padding-bottom: 0px; padding-top: 0px;"
                        onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $users->id . '\').submit();"
                    >
                        Delete
                        <span class="btn-label btn-label-right"><i class="fa fa-trash"></i></span>
                    </a>

                    <form id="delete-form-' . $users->id . '" action="' . route('admin.users.destroy', $users->id) . '" method="POST" style="display: none;">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                ';
            })
            ->rawColumns(['user', 'action'])->make(true);
    }
}
