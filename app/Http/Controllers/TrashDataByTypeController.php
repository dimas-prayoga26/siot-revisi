<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TrashBin;
use App\Models\UserData;
use App\Models\TrashData;
use App\Models\WeightScale;
use Illuminate\Http\Request;
use App\Models\TrashBinCounter;
use App\Models\TrashTypeDetail;
use Yajra\DataTables\DataTables;

class TrashDataByTypeController extends Controller
{
    public function index()
    {
        // Mengambil user_id dari tabel TrashBin
        $userIds = WeightScale::pluck('user_id');

        // dd($userIds);
        // Mengambil pengguna dengan role 'user' dari tabel User menggunakan Spatie Laravel Permission
        $users = User::whereIn('id', $userIds)
                     ->role('garbage-officer')
                     ->with('userData') // Memuat relasi userData
                     ->get();

        $years = TrashData::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
 

        return view('contents.data-weight-by-type.index', compact('years' ,'users'));
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
    Carbon::setLocale('id');

    // Ambil tahun dan bulan dari request, jika tidak ada gunakan tahun dan bulan sekarang
    $year = $request->get('year', now()->year);
    $month = $request->get('month', now()->month);

    $dataTrashQuery = TrashData::with(['trashType', 'trashTypeDetail'])
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->whereHas('trashType', function ($query) {
            $query->whereIn('type', ['organic', 'anorganic', 'recyclable']);
        })
        ->orderBy('created_at', 'desc'); // Urutkan berdasarkan tanggal secara descending

    $dataTrash = $dataTrashQuery->get();

    // Kelompokkan data berdasarkan tanggal
    $groupedData = $dataTrash->groupBy(function($item) {
        return $item->created_at->format('Y-m-d');
    });

    $trashDataArray = [];

    foreach ($groupedData as $date => $items) {
        $totalWeightDaily = $items->sum('weight');

        foreach ($items as $item) {
            $weight = $item->weight;
            $created_at = $item->created_at->setTimezone('Asia/Jakarta');
            $trashType = $item->trashType->type;

            $detailType = '-';
            if ($trashType == 'recyclable' && $item->trashTypeDetail) {
                $detailType = $item->trashTypeDetail->type;
            }

            $trashDataArray[] = [
                'date' => $created_at->format('Y-m-d'),
                'jam' => $created_at->format('H:i'),
                'type_sampah' => $trashType,
                'detail_type_sampah' => $detailType,
                'berat' => number_format($weight, 2) . ' Kg'
            ];
        }
    }

    return DataTables::of($trashDataArray)->make(true);
}





















public function showHistory(Request $request)
{
    Carbon::setLocale('id');

    $garbageOfficerId = $request->input('garbage_officer_id');
    $year = $request->input('year', now()->year); // Default to current year
    $month = $request->input('month');

    // Jika garbage_officer_id tidak ada, kembalikan hasil kosong
    if (!$garbageOfficerId) {
        return DataTables::of(collect())->make(true);
    }

    $dataTrashQuery = TrashData::with('trashType')
        ->whereYear('created_at', $year)
        ->where('garbage_officer_id', $garbageOfficerId);

    if ($month) {
        $dataTrashQuery->whereMonth('created_at', $month);
    }

    $dataTrash = $dataTrashQuery->get();

    if ($month) {
        // Jika bulan dipilih, grupkan data berdasarkan hari dan urutkan tanggal dari yang terbaru hingga terlama
        $trashWeightsByDateAndOfficer = [];

        foreach ($dataTrash as $item) {
            $weight = $item->weight;
            $created_at = $item->created_at->setTimezone('Asia/Jakarta');
            $trashType = $item->trashType->type; // Assuming 'type' is the field that holds the type name (anorganik, organik, daur ulang)
            $garbageOfficerName = UserData::where('user_id', $garbageOfficerId)->first()->name ?? 'N/A';

            $key = $garbageOfficerId . '_' . $created_at->toDateString();

            if (!isset($trashWeightsByDateAndOfficer[$key])) {
                $trashWeightsByDateAndOfficer[$key] = [
                    'date' => $created_at->translatedFormat('Y-m-d'), // Format tanggal dengan nama hari dalam bahasa Indonesia
                    'garbage_officer_id' => $garbageOfficerName,
                    'anorganic' => 0,
                    'organic' => 0,
                    'recyclable' => 0,
                ];
            }

            if ($trashType == 'anorganic') {
                $trashWeightsByDateAndOfficer[$key]['anorganic'] += $weight;
            } elseif ($trashType == 'organic') {
                $trashWeightsByDateAndOfficer[$key]['organic'] += $weight;
            } elseif ($trashType == 'recyclable') {
                $trashWeightsByDateAndOfficer[$key]['recyclable'] += $weight;
            }
        }

        // Menambahkan "Kg" ke setiap nilai berat
        foreach ($trashWeightsByDateAndOfficer as &$data) {
            $data['anorganic'] .= ' Kg';
            $data['organic'] .= ' Kg';
            $data['recyclable'] .= ' Kg';
        }

        // Urutkan tanggal dari yang terbaru hingga terlama
        $dataMap = collect($trashWeightsByDateAndOfficer)->sortByDesc(function($item) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $item['date']);
        })->values()->all();
    } else {
        // Jika bulan tidak dipilih, grupkan data berdasarkan bulan dan urutkan bulan dari Januari hingga Desember
        $trashWeightsByMonthAndOfficer = [];

        foreach ($dataTrash as $item) {
            $weight = $item->weight;
            $created_at = $item->created_at->setTimezone('Asia/Jakarta');
            $trashType = $item->trashType->type; // Assuming 'type' is the field that holds the type name (anorganik, organik, daur ulang)
            $garbageOfficerName = UserData::where('user_id', $garbageOfficerId)->first()->name ?? 'N/A';

            $key = $garbageOfficerId . '_' . $created_at->format('Y-m');

            if (!isset($trashWeightsByMonthAndOfficer[$key])) {
                $trashWeightsByMonthAndOfficer[$key] = [
                    'date' => $created_at->format('Y-m'), // Gunakan format yang dikenali Carbon
                    'garbage_officer_id' => $garbageOfficerName,
                    'anorganic' => 0,
                    'organic' => 0,
                    'recyclable' => 0,
                ];
            }

            if ($trashType == 'anorganic') {
                $trashWeightsByMonthAndOfficer[$key]['anorganic'] += $weight;
            } elseif ($trashType == 'organic') {
                $trashWeightsByMonthAndOfficer[$key]['organic'] += $weight;
            } elseif ($trashType == 'recyclable') {
                $trashWeightsByMonthAndOfficer[$key]['recyclable'] += $weight;
            }
        }

        // Menambahkan "Kg" ke setiap nilai berat
        foreach ($trashWeightsByMonthAndOfficer as &$data) {
            $data['anorganic'] .= ' Kg';
            $data['organic'] .= ' Kg';
            $data['recyclable'] .= ' Kg';
        }

        // Urutkan bulan dari Januari hingga Desember
        $dataMap = collect($trashWeightsByMonthAndOfficer)->sortBy(function($item) {
            return \Carbon\Carbon::createFromFormat('Y-m', $item['date']);
        })->values()->all();
    }

    return DataTables::of($dataMap)->make(true);
}

}
