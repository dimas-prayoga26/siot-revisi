<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\TrashBin;
use App\Models\UserData;
use App\Models\TrashData;
use Illuminate\Http\Request;
use App\Models\TrashBinCounter;
use Yajra\DataTables\DataTables;

class TrashDataAllController extends Controller
{
    public function index()
    {
        // Mengambil user_id dari tabel TrashBin
        $userIds = TrashBin::pluck('user_id');

        // Mengambil pengguna dengan role 'user' dari tabel User menggunakan Spatie Laravel Permission
        $users = User::whereIn('id', $userIds)
                     ->role('user')
                     ->with('userData') // Memuat relasi userData
                     ->get();

        $years = TrashData::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
 

        return view('contents.data-weight-all.index', compact('years' ,'users'));
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

        $dataTrashQuery = TrashData::with(['trashType'])
            ->whereHas('trashType', function ($query) {
                $query->where('type', 'all');
            })
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc'); // Urutkan berdasarkan tanggal secara descending

        $dataTrash = $dataTrashQuery->get();

        $trashDataArray = [];

        foreach ($dataTrash as $item) {
            $weight = $item->weight;
            $created_at = $item->created_at->setTimezone('Asia/Jakarta');

            $trashDataArray[] = [
                'date' => $created_at->format('Y-m-d'),
                'jam' => $created_at->format('H:i'),
                'berat' => number_format($weight, 2) . ' Kg'
            ];
        }

        return DataTables::of($trashDataArray)->make(true);
    }

}
