<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\TrashBin;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $data['officers'] = User::role('garbage-officer')->with('userData')->get();
        $data['status'] = TrashBin::where('user_id', auth()->guard('api')->user()->id)->pluck('status')->first();
        return Helper::successMessage(data: $data);
    }
}
