<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:50|required',
            'address' => 'string|required',
            'image' => 'image|file|max:2048|nullable',
        ]);

        if ($validator->fails()) {
            return Helper::validationFailMessage($validator->messages()->first());
        }

        try {
            $userData = UserData::where('user_id', auth()->guard('api')->user()->id)->first();
            $requests = [
                'name' => $request->name,
                'address' => $request->address,
            ];
            if ($userData) {
                if ($request->hasFile('image')) {
                    if ($userData->image) {
                        Storage::disk('public')->delete($userData->image);
                    }
    
                    $imageName = $request->file('image')->store('profile_images', 'public');
                    
                    $requests['image'] = $imageName;
                }
    
                $userData->update($requests);
    
                return Helper::successMessage("Berhasil mengubah profil",
                User::with('userData')->find($userData->user_id));
            } else {
                return Helper::notFoundMessage();
            }
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    public function accountSetting(Request $request, string $id){
        $rules = [
            'email' => 'required|email',
            'username' => 'required|max:50',
            'phone_number' => 'required|max:20',
        ];
        $user = User::find($id);
        $userData = UserData::where('user_id', $id)->first();

        if ($request->email != $user->email) {
            $rules['email'] =  'required|email|unique:users';
        }

        if ($request->username != $user->username) {
            $rules['username'] = 'required|max:50|unique:users';
        }
        if ($request->phone_number != $userData->phone_number) {
            $rules['phone_number'] = 'required|max:20|unique:user_datas';
        }

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return Helper::validationFailMessage($validator->messages()->first());
        }

        try {
            DB::beginTransaction();
                $user->update([
                    'email' => $request->email,
                    'username' => $request->username
                ]);
                $userData->update([
                    'phone_number' => $request->phone_number
                ]);
            DB::commit();
            return Helper::successMessage('Data berhasil di ubah',
            User::with('userData')->find($id));
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helper::internalServerErrorMessage($th->getMessage());
        }

    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return Helper::validationFailMessage($validator->messages()->first());
        }

        try {
            $user = Auth::guard('api')->user();
    
            if (!Hash::check($request->current_password, $user->password)) {
                return Helper::validationFailMessage('Password saat ini salah');
            }
    
            $user->password = Hash::make($request->new_password);
            $user->save();

            Auth::logout();
    
            return Helper::successMessage('Password berhasil diperbarui');
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }

    }
}
