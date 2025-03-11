<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomPolicy;
use Yajra\DataTables\Facades\DataTables;

class RoomPolicyController extends Controller
{
    public function index()
    {
        return view('room-policies.index');
    }

    public function create()
    {
        return view('room-policies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:room_policies',
            'description' => 'nullable|string'
        ]);

        RoomPolicy::create($request->only(['name', 'description']));

        alert()->success('Success','Added Successfully'); 
        return redirect()->route('room-policies.index');
    }

    public function edit(RoomPolicy $roomPolicy)
    {
        return view('room-policies.edit', compact('roomPolicy'));
    }

    public function update(Request $request, RoomPolicy $roomPolicy)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:room_policies,name,'.$roomPolicy->id,
            'description' => 'nullable|string'
        ]);

        $roomPolicy->update($request->only(['name', 'description']));

        alert()->success('Success','Updated Successfully'); 
        return redirect()->route('room-policies.index');
    }

    public function destroy(RoomPolicy $roomPolicy)
    {
        $roomPolicy->delete();
        
        alert()->success('Success','Deleted Successfully'); 
        return redirect()->route('room-policies.index');
    }

    public function datatable()
    {
        $policies = RoomPolicy::query();

        return DataTables::of($policies)
            ->addColumn('actions', function($policy) {
                return view('room-policies.partials.actions', compact('policy'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
