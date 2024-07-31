<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeightScale;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WeightScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.weight-scale.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userIds = User::whereHas('roles', function ($query) {
            $query->where('name', 'garbage-officer');
        })->pluck('id');

        $unListUser = [];

        foreach ($userIds as $userId) {
            $cekTrashBinListId = WeightScale::where('user_id', $userId)->exists();
            
            if (!$cekTrashBinListId) {
                $unListUser[] = $userId;
            }
        }

        $users = User::whereIn('id', $unListUser)->get();
        $unique_id = $request->query('unique_id', '');

        return view('contents.weight-scale.create', compact('unique_id','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', getError($validator->errors()->all()))
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $WeightScale = WeightScale::create([
                'user_id' => $request->user_id,
                'unique_id' => $request->unique_id,
                'name' => $request->name,
                'pin' => 123456,
                'latitude' => null,
                'longitude' => null,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return redirect()->route('weight-scale.index')->with('success', 'Berhasil membuat alat baru!');
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

            WeightScale::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Berhasil menghapus alat!',]);
    }

    // public function isActive(Request $request)
    // {
    //     // dd($request);
    //     $WeightScale = WeightScale::find($request->id);

    //     if ($WeightScale) {
    //         $WeightScale->update([
    //             'is_active' => $request->state,
    //         ]);

    //         return response()->json([
    //             'status'  => true,
    //             'message' => 'Success Update Data!',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Data not found!',
    //         ], 404); // or handle the situation according to your requirements
    //     }
    // }


    public function datatable(Request $request)
    {
        
        $data = WeightScale::with('user', 'user.userData')->get();

        return DataTables::of($data)->make();
    }
}
