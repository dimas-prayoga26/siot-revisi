<?php

namespace App\Http\Controllers;

use App\Models\TrashData;
use App\Models\User;
use App\Models\UserData;
use App\Models\WeightScale;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.user.userPetugas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contents.user.userPetugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => 'unique:users|min:4',
            'email'     => 'required|unique:users',
            'password'  => 'required',
            'name'      => 'required',
            'phone_number' => 'required',
            'address'   => 'required',
            'image'     => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', getError($validator->errors()->all()))
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('garbage-officer');

            // Upload and store image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $imagePath = 'images_profile/' . $imageName; // Adjust the path as needed
                Storage::disk('public')->put($imagePath, file_get_contents($image));
            }

            $member = UserData::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'image' => $imagePath,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return redirect()->route('petugas.index')->with('success', 'Berhasil membuat account petugas sampah!');
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
        $data['petugas'] = UserData::find($id);

        return view('contents.user.userPetugas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'phone_number'  => 'required',
            'address'       => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $userData = UserData::find($id);

            // Update UserData
            $userData->update([
                'name'          => $request->name,
                'phone_number'  => $request->phone_number,
                'address'       => $request->address,
            ]);

            // Upload and store image
            if ($request->hasFile('image')) {
                // Delete the existing image if a new one is uploaded
                Storage::disk('public')->delete($userData->image);

                $image = $request->file('image');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $imagePath = 'images_profile/' . $imageName; // Adjust the path as needed
                Storage::disk('public')->put($imagePath, file_get_contents($image));

                // Update the image path in UserData
                $userData->update(['image' => $imagePath]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return redirect()->route('petugas.index')->with('success', 'Berhasil mengupdate account garbage-officer!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {    
            $user_id = UserData::find($id)->user_id;
            
            TrashData::where('garbage_officer_id', $user_id)->delete();;
            WeightScale::where('user_id', $user_id)->delete();
            UserData::find($id)->delete();
            User::where('id', $user_id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Success Delete account garbage-officer!',]);
    }

    public function datatable(Request $request)
    {
        $logged = Auth::user()->id;
        // dd($logged   );
        // Fetch all users with the "admin" role and their associated userData
        $petugasData = User::whereHas('roles', function ($query) {
            $query->where('name', 'garbage-officer');
        })->with('userData')->where('id', '!=', $logged)->get();

        $data = $petugasData->pluck('userData');

        return DataTables::of($data)->editColumn('image', function ($data) {
            $storagePath = storage_path('app/public/' . $data->image);
            if (file_exists($storagePath)) {
                $imagePath = asset('storage/' . $data->image);
            } else {
                $imagePath = asset('assets/images/faces/1.jpg');
            }
            return $imagePath;
        })->make();
    }
}
