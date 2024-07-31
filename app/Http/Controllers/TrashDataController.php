<?php

namespace App\Http\Controllers;

use App\Models\TrashBin;
use Carbon\Carbon;
use App\Models\UserData;
use App\Models\TrashData;
use Illuminate\Http\Request;
use App\Models\TrashBinCounter;
use Yajra\DataTables\DataTables;

class TrashDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contents.data-weight-garbage.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    public function datatable(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $today = Carbon::today()->toDateString();

        $dataTrash = TrashData::with('trashType')
            ->whereDate('created_at', $today)
            ->whereHas('trashType', function ($query) {
                $query->where('type', 'all');
            })
            ->get();

        $trashWeightsByDate = [];

        foreach ($dataTrash as $item) {
            $weight = $item->weight;
            $created_at = $item->created_at->format('Y-m-d'); 

            if (!isset($trashWeightsByDate[$created_at])) {
                $trashWeightsByDate[$created_at] = 0;
            }

            $trashWeightsByDate[$created_at] += $weight;
        }
        
        $trashWeightsByDateAndOfficer = [];

        foreach ($dataTrash as $item) {
            $weight = $item->weight;
            $created_at = $item->created_at->setTimezone('Asia/Jakarta');

            $garbage_officer_id = $item->user_id;

            // dd($garbage_officer_id);

            $key = $garbage_officer_id . '_' . $created_at->toDateString();

            $garbageOfficerName = null;
            $garbage = $garbage_officer_id;
            $userData = UserData::where('user_id', $garbage)->first();
            if ($userData) {
                $garbageOfficerName = $userData->name;
            }

            // Jika kunci sudah ada di dalam array, tambahkan berat sampah baru
            if (isset($trashWeightsByDateAndOfficer[$key])) {
                $trashWeightsByDateAndOfficer[$key]['weight'] += $weight;
            } else {
                // Jika kunci belum ada, buat entri baru di dalam array
                $trashWeightsByDateAndOfficer[$key] = [
                    'date' => $created_at->translatedFormat('d / l'),
                    'garbage_officer_id' => $garbageOfficerName,
                    'weight' => $weight,
                ];
            }
        }

        $dataMap = collect($trashWeightsByDateAndOfficer)->values()->all();

        
        return DataTables::of($dataMap)->make();


    }
}
