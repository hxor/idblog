<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'tagline' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required'
        ]);
        
        $setting = Setting::updateOrCreate([
            'id' => 1,
        ], $request->all());
        return redirect()->route('admin.settings.index');
    }
}
