<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class Helper {

    public static function successMessage(string $message = null, $data = null){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function badRequestMessage(string $message = null){
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 400);
    }

    public static function validationFailMessage(string $message = null){
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 422);
    }

    public static function unAuthorizedMessage(string $message = "Anda belum login"){
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 401);
    }

    public static function internalServerErrorMessage(string $error = null){
        return response()->json([
            'success' => false,
            'message' => "Terjadi kesalahan",
            'error' => $error,
        ], 500);
    }

    public static function notFoundMessage(){
        return response()->json([
            'success' => false,
            'message' => "Data tidak ditemukan",
        ], 404);
    }


    public static function getRoleName(string $id){
        $user = User::find($id);
        $roleName = $user->getRoleNames()->first();
        return $roleName;
    }


    public static function pushNotification(string $type, int $payload = null, int $year = null, int $month = null
    , string $id=null, string $title = null, string $body = null, string $category = null, string $alertType = 'info'
    , string $userId = null, int $totalInvoice = null,string $topic = 'garbageOfficer', $trashBin = null, string $fcm = null ){
        $notification = [];
        $data = [];
        if($type == 'summary'){
            $notification = [
                    'data' => [
                        'type' => 'summary',
                        'category' => $category,
                        'payload' => $payload,
                        'year' => $year ?? Carbon::now()->year,
                        'month' => $month ?? Carbon::now()->month,
                    ],
                    'topic' => $topic
                ];
        }else if($type == 'regular-notification'){
            $notification = [
                'notification' => [
                    'title' => $title ?? "Pemberitahuan",
                    'body' => $body ?? "Tempat sampah Anda sudah diangkut"
                ],
            ];
            if ($fcm != null) {
                $notification['token'] = $fcm;
            } else {
                $notification['topic'] = $topic;
            }
        }else if($type == 'trashbin-status'){
            if ($payload >= 95) {
                $notification = [
                    'notification' =>[
                        'title' => $title ?? 'Tempat Sampah Penuh',
                        'body' => $body ?? 'Ada tempat sampah yang memerlukan tindakan',
                    ],
                    'data' => [
                        'type' => $type,
                        'id' => $id,
                        'payload' => $payload,
                        'alert_type' => $alertType,
                        'trash_bin' => $trashBin
                    ],
                ];
                if ($fcm != null) {
                    $notification['token'] = $fcm;
                } else {
                    $notification['topic'] = $topic;
                }
                $data = [
                    'title' => $title ?? 'Tempat Sampah Penuh',
                    'content' => $body ?? 'Ada tempat sampah yang memerlukan tindakan',
                    'type' => $alertType == 'info' ? 'error' : $alertType,
                    'traash_bin_id' => $id  ?? '',
                    'user_id' => $userId,
                ];
            }else if($payload >= 75){
                $notification = [
                    'notification' =>[
                        'title' => $title ?? 'Tempat Sampah Hampir Penuh',
                        'body' => $body ?? 'Ada tempat sampah yang memerlukan tindakan',
                    ],
                    'data' => [
                        'type' => $type,
                        'id' => $id,
                        'payload' => $payload,
                        'alert_type' => $alertType,
                        'trash_bin' => $trashBin
                    ],
                ];
                if ($fcm != null) {
                    $notification['token'] = $fcm;
                } else {
                    $notification['topic'] = $topic;
                }
                $data = [
                    'title' => $title ?? 'Tempat Sampah Hampir Penuh',
                    'content' => $body ?? 'Ada tempat sampah yang memerlukan tindakan',
                    'type' => $alertType == 'info' ? 'warning' : $alertType,
                    'traash_bin_id' => $id  ?? '',
                    'user_id' => $userId,
                ];
            }else{
                $notification = [
                    'data' => [
                        'type' => $type,
                        'id' => $id,
                        'payload' => $payload,
                    ],
                ];
                if ($fcm != null) {
                    $notification['token'] = $fcm;
                } else {
                    $notification['topic'] = $topic;
                }
            }
        }elseif ($type == 'chart-data') {
            $notification = [
                'data' => [
                    'type' => $type,
                    'payload' => $payload,
                    'year' => $year,
                    'month' => $month,
                ],
                'topic' => $topic
            ];
        }elseif ($type == 'invoice') {
            
            $notification = [
                'notification' =>[
                    'title' => $title ?? 'Tagihan Bulan Ini',
                    'body' => $body ?? 'Harap segera melakukan pembayaran bulan ini',
                ],
                'data' => [
                    'type' => $type,
                    'total_invoice' => $totalInvoice,
                ],
            ];
            if ($fcm != null) {
                $notification['token'] = $fcm;
            } else {
                $notification['topic'] = $topic;
            }
            $data = [
                'title' => $title ?? 'Tagihan Bulan Ini',
                'content' => $body ?? 'Harap segera melakukan pembayaran bulan ini',
                'type' => $alertType == 'info' ? 'error' : $alertType,
                'user_id' => $userId,
            ];
        }elseif ($type == 'picked-up-notifications') {
            $notification = [
                'notification' =>[
                    'title' => $title ?? 'Selamat',
                    'body' => $body ?? 'Tempat sampah Anda sudah bersih kembali',
                ],
                // 'topic' => $topic
                'token' => $fcm ?? '',
                'data' => [
                    'type' => 'picked-up-notifications',
                ],
            ];
        }

        if($data != null || count($data) > 0){
            $notificationData =  Notification::create($data);
            $notification['data']['notification_data'] = $notificationData;
        }

        $firebase = (new Factory)
        ->withServiceAccount(base_path('si-ara-firebase-adminsdk-pb9pv-d3e0196954.json'));
        
        $messaging = $firebase->createMessaging();
        
        $message = CloudMessage::fromArray($notification);
        
        $messaging->send($message);
    }

    function formatRupiah($number)
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }
}