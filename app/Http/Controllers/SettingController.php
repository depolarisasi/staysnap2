<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::all();
        return view('setting.index', compact('setting'));
    }

    public function create()
    {
        return view('setting.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'nullable|string',
        ]);

        Setting::create($request->only('key', 'value'));

        alert()->success('Success', 'Config Berhasil Dibuat');
        return redirect()->route('setting.index');
    }

    public function edit($id)
    {
        $setting = Setting::find($id);
        return view('setting.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'value' => 'nullable|string',
        ]);

        $setting->update($request->only('value'));

        alert()->success('Success', 'Config Berhasil Diubah');
        return redirect()->route('setting.index');
    }

    public function destroy($id)
    {
        $setting->delete();
        return redirect()->route('setting.index');
    }
}
