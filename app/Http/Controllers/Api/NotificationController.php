<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\TrashData;
use App\Models\TrashType;
use App\Models\Notification;
use Kreait\Firebase\Factory;
use App\Http\Controllers\Controller;
use App\Models\TrashBin;
use App\Notifications\FullNotification;
use Carbon\Carbon;
use NotificationChannels\Fcm\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationController extends Controller
{
    public function index(string $id){
        try {
            if (auth()->guard('api')->user()->hasRole('user')) {
                $data = Notification::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            }else{
                $data = Notification::where('user_id', $id)->orWhere('user_id', null)->orderBy('created_at', 'desc')->get();
            }
            return Helper::successMessage('Berhasil get data', $data);
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    public function sendPushNotification()
    {
        //summary push notif example
        Helper::pushNotification(category: 'all', type: 'summary',payload: 90, year: Carbon::now()->year, month: Carbon::now()->month);

        //trashbin status example
        // $trashBin = TrashBin::with('user', 'user.userData')->first();
        // Helper::pushNotification(body: 'Tempat sampah milik keluarga Bpk.ujang hampir penuh', 
        // type: 'trashbin-status', payload: 90, id: $trashBin->id, alertType: 'error', trashBin: $trashBin);

        //trashbin status user example
        // Helper::pushNotification(body: 'Tempat sampah Anda hampir penuh', 
        // type: 'trashbin-status', payload: 50, topic:'user');

        //invoice notif
        // Helper::pushNotification(
        // type: 'invoice', totalInvoice: 10000, topic:'user');

        // //Picked up user trashbin
        // Helper::pushNotification(
        // type: 'picked-up-notifications', topic:'user', title:"Selamat", body:"Tempat sampah Anda sudah bersih kembali");

        //chart data notification example
        // Helper::pushNotification( type: 'chart-data', payload: 25, year: 2024, month: 5);
    }

    public function updateIsReaded(string $id) {
        try {
            Notification::find($id)->update([
                'isReaded' => true
            ]);
            return Helper::successMessage();
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }
}
