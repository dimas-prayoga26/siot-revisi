<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('userData');

        // Periksa apakah gambar ada di storage
        $imagePath = 'public/' . ($user->userData->image ?? '');
        if (!Storage::exists($imagePath) || empty($user->userData->image)) {
            // Jika gambar tidak ada atau kosong, gunakan gambar default
            $user->userData->image = 'assets/images/faces/5.jpg';
        } else {
            // Jika gambar ada, gunakan jalur yang sesuai
            $user->userData->image = Storage::url($user->userData->image);
        }
    
        return view('contents.profile', compact('user'));
    }

    public function edit($id)
    {
        $Users = User::with('userData')->find($id);
        // dd($Users);
        if ($Users) {
            return response()->json([
                'data' => $Users,
            ]);
        } else {
            return response()->json([
                'message' => 'User tidak ditemukan.',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'email' => 'nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable',
            'image' => 'required',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
                }
                
                
        try {
            DB::beginTransaction();

            
            $profile = UserData::with('user')->where('user_id', $id)->firstOrFail();
           // Update UserData
            $profile->update([
                'name'          => $request->name,
                'phone_number'  => $request->phone_number,
                'address'       => $request->address,
            ]);

            // Update email di tabel User
            $profile->user->update([
                'email' => $request->email,
            ]);

            // Upload and store image
            if ($request->hasFile('image')) {
                // Delete the existing image if a new one is uploaded
                Storage::disk('public')->delete($profile->image);

                $image = $request->file('image');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $imagePath = 'images_profile/' . $imageName; // Adjust the path as needed
                Storage::disk('public')->put($imagePath, file_get_contents($image));

                // Update the image path in UserData
                $profile->update(['image' => $imagePath]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Customer and address updated successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update customer and address.',
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
