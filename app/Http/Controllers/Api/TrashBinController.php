<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\TrashBin;
use App\Models\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrashData;
use App\Models\TrashType;
use Google\Api\ResourceDescriptor\History;
use Illuminate\Support\Facades\DB;

class TrashBinController extends Controller
{
    public function index(){
        try {
            return Helper::successMessage('Berhasil get data', TrashBin::with('user', 'user.userData')->where('is_active', true)->get());
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    public function updateStatus(Request $request, string $uniqueId){
        try {
            $trashBin = TrashBin::with('user')->where('unique_id', $uniqueId)->where('is_active', true)->first();
            if ($trashBin) {
                $trashBin->update([
                    'status' => $request->status,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);

                $alertType = $trashBin->status >= 90 ? 'error' : 'warning';
                
                Helper::pushNotification(type: 'trashbin-status', payload: (int)$trashBin->status, id: $trashBin->id, trashBin: $trashBin, alertType: $alertType);
                Helper::pushNotification(type: 'trashbin-status', payload: (int)$trashBin->status, id: $trashBin->id, trashBin: $trashBin,  alertType: $alertType, 
                fcm:$trashBin->user->fcm_token, userId: $trashBin->user->id);

                return Helper::successMessage();
            }
                
            return Helper::notFoundMessage();
            
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    public function updatePickingStatus(string $id, string $status){
        try {
            DB::beginTransaction();
            $trashBin = TrashBin::with('user')->find($id);
            if ($status == 'completed') {
                if($trashBin->waste_pickup_status == 'arrived'){
                    $weight = ($trashBin->status/100) * $trashBin->capacity;
                    Helper::pushNotification(category: 'all', type: 'summary',payload: $weight, year: Carbon::now()->year, month: Carbon::now()->month);
                    TrashData::create(
                        [
                            'user_id' => $trashBin->user->id,
                            'garbage_officer_id' => auth()->guard('api')->user()->id,
                            'trash_bin_id' => $trashBin->id,
                            'weight' => $weight,
                            'trash_type_id' => TrashType::where('type', 'all')->pluck('id')->first(),
                        ]
                    );
                    $trashBin->update([
                        'status' => 0,
                        'waste_pickup_status' => $status
                    ]);
    
                    //Buat notifikasi untuk user disini
                    Helper::pushNotification(type: 'picked-up-notifications', fcm: $trashBin->user->fcm_token, title:"Selamat", body:"Tempat sampah Anda sudah bersih kembali");
                    Helper::pushNotification(type: 'trashbin-status', payload: 0, id: $trashBin->id, trashBin: $trashBin);
                    
                    DB::commit();
                    return Helper::successMessage("Sampah berhasil diangkut!");
                }else{
                    DB::rollBack();
                    return Helper::badRequestMessage("Pastikan Anda telah sampai di lokasi terlebih dahulu");
                }
            }else if($status == 'in_progress'){
                if (($trashBin->waste_pickup_status == 'pending' || $trashBin->waste_pickup_status == 'completed') && 
                    $trashBin->waste_pickup_status != 'in_progress'
                ) {
                    $trashBin->update([
                        'waste_pickup_status' => $status
                    ]);
                    DB::commit();
                    return Helper::successMessage($status == 'in_progress' ? "Jangan lupa konfirmasi pengangkutan setelah sampai!" : null);
                }else{
                    DB::rollBack();
                    return Helper::badRequestMessage("Sampah sudah diangkut petugas lain!");
                }

            }
            $trashBin->update([
                'waste_pickup_status' => $status
            ]);
            DB::commit();
            return Helper::successMessage($status == 'in_progress' ? "Jangan lupa konfirmasi pengangkutan setelah sampai!" : null);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }
}
