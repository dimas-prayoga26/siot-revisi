<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TrashBin;
use App\Models\TrashData;
use App\Models\TrashType;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index()
    {

        $data = TrashBin::first();

        // dd($data);

        return view('contents.maps.index', compact('data'));
    }

    public function getMapData() {
        // Ambil semua jenis sampah
        $trashTypes = TrashType::all()->keyBy('type'); // Menggunakan keyBy untuk akses cepat
        
        $currentDate = Carbon::today(); // Mendapatkan tanggal saat ini
        
        // Ambil semua data tempat sampah dengan relasi user
        $locations = TrashBin::with('user', 'user.userData')->get();
        
        $mapData = []; // Array untuk menyimpan data lokasi dan berat sampah
        
        // Loop untuk setiap lokasi dan tentukan berat sampah per jenis
        foreach ($locations as $location) {
            $userId = optional($location->user)->id; // Dapatkan user_id
            $userName = optional($location->user)->username; // Dapatkan nama pengguna
            
            if ($userId) {
                // Berat sampah untuk setiap jenis
                $weights = [
                    'organic' => 0,
                    'anorganic' => 0,
                    'recyclable' => 0,
                    'all' => 0, // Total semua jenis
                ];
                
                // Untuk setiap jenis sampah, hitung total berat
                foreach (array_keys($weights) as $type) {
                    // Dapatkan TrashType berdasarkan jenis sampah
                    $trashType = $trashTypes->get($type);
                    
                    if ($trashType) {
                        $totalWeight = TrashData::where('user_id', $userId)
                            ->where('trash_type_id', $trashType->id)
                            ->whereDate('created_at', $currentDate) // Hanya untuk tanggal ini
                            ->sum('weight'); // Total berat sampah
                        
                        $weights[$type] = $totalWeight;
                    }
                }
                
                // Tambahkan data lokasi ke mapData dengan berat sampah per jenis
                $mapData[] = [
                    'lat' => $location->latitude,
                    'lng' => $location->longitude,
                    'name' => $userName,
                    'organic' => $weights['organic'], // Berat sampah organik
                    'anorganic' => $weights['anorganic'], // Berat sampah anorganik
                    'recyclable' => $weights['recyclable'], // Berat sampah dapat didaur ulang
                    'all' => $weights['all'], // Total berat semua jenis sampah
                ];
            }
        }
        
        // Kembalikan respons JSON dengan data lokasi dan berat sampah per jenis
        return response()->json(['locations' => $mapData]);
    }
    
    
    
    
}
