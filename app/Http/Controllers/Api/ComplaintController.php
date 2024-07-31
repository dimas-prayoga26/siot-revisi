<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function index(){
        try {
            return Helper::successMessage(data: Complaint::with('user', 'user.userData')->where('status', '!=', 'resolved')->get());
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    public function create(Request $request){
        try {
            $data = [
                'user_id' => auth()->guard('api')->user()->id,
                'desc' => $request->desc,
                'status' => 'submitted',
            ];
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->store('complaint_images', 'public');
                
                $data['image'] = $imageName;
            }
            Complaint::create($data);
            return Helper::successMessage("Berhasil mengajukan keluhan");
        } catch (\Throwable $th) {
            return Helper::badRequestMessage($th->getMessage());
        }
    }
    
    public function handleComplaint(Request $request){
        try {
            DB::beginTransaction();
            $requests = [
                'desc' => $request->desc,
                'complaint_id' => $request->complaint_id,
                'user_id' => $request->user_id,
            ];
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->store('complaints', 'public');
                
                $requests['image'] = $imageName;
            }
            ComplaintResponse::updateOrCreate(
                ['complaint_id' => $requests['complaint_id'],],
                $requests
            );
            Complaint::find($request->complaint_id)->update([
                'status' => 'needs_validation',
            ]);
            DB::commit();
            return Helper::successMessage("Berhasil, menunggu Admin untuk melakukan validasi");
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }
}
