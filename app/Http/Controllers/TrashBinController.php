<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TrashBin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\Console;

class TrashBinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.trash-bin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userIds = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->pluck('id');

        $unListUser = [];

        foreach ($userIds as $userId) {
            $cekTrashBinListId = TrashBin::where('user_id', $userId)->exists();
            
            if (!$cekTrashBinListId) {
                $unListUser[] = $userId;
            }
        }

        $users = User::whereIn('id', $unListUser)->get();
        $unique_id = $request->query('unique_id', '');

        // dd($unique_id);

        return view('contents.trash-bin.create', compact('unique_id','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'capacity'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', getError($validator->errors()->all()))
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $trashBin = TrashBin::create([
                'user_id' => $request->user_id,
                'unique_id' => $request->unique_id,
                'status' => 0,
                'capacity' => $request->capacity,
                'latitude' => null,
                'longitude' => null,
                'is_active' => false,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return redirect()->route('trash-bin.index')->with('success', 'Berhasil membuat alat baru!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {    

            TrashBin::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Berhasil menghapus alat!',]);
    }

    public function isActive(Request $request)
    {
        // dd($request);
        $trashBin = TrashBin::find($request->id);

        if ($trashBin) {
            $trashBin->update([
                'is_active' => $request->state,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Success Update Data!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found!',
            ], 404); // or handle the situation according to your requirements
        }
    }


    public function datatable(Request $request)
    {
        
        $data = TrashBin::with('user', 'user.userData')->get();

        return DataTables::of($data)->make();
    }
}
