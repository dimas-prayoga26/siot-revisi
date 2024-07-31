<?php

namespace App\Http\Controllers;

use App\Models\MetaDate;
use App\Models\Schedule;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class MetaDataDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $getId = Schedule::pluck('meta_date_id');
        // dd($getId);
        $latestMetaData = MetaDate::oldest('date')->first();
        $latestMetaDataDate = Carbon::parse($latestMetaData->date)->timezone('Asia/Jakarta');

        // $today = Carbon::createFromDate(2024, 5, 20, 'Asia/Jakarta');
        $today = Carbon::now('Asia/Jakarta');

        $sevenDaysAhead = $latestMetaDataDate->copy()->addDays(6)->startOfDay();

        $isPastWeek = $today > $sevenDaysAhead;

        // dd($getId);

        return view('contents.meta-data.meta-data-date-weekly.index', compact('isPastWeek'));
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

        $metaIds = MetaDate::pluck('id');

        MetaDate::whereIn('id', $metaIds)->delete();

        try {
            DB::beginTransaction();


            // Buat data baru untuk 7 hari ke depan dari tanggal saat ini
            for ($i = 1; $i < 8; $i++) {
                MetaDate::create([
                    'date' => Carbon::now()->addDays($i)
                ]);
            }

            DB::commit();

            return redirect()->route('pengaturan-tanggal-mingguan.index')->with('success', 'Data sudah berhasil di reset!.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Jika terjadi kesalahan, Anda dapat menangani atau memperlihatkan pesan kesalahan kepada pengguna
            return redirect()->route('pengaturan-tanggal-mingguan.index')->with('error', 'Failed to reset data. Please try again later.');
        }
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
        $data = MetaDate::get();

        return DataTables::of($data)
            ->editColumn('date', function ($metaDate) {
                // Ubah format tanggal menjadi nama bulan
                return \Carbon\Carbon::parse($metaDate->date)->format('d F Y'); // 'F' digunakan untuk mendapatkan nama bulan dalam format teks
            })
            ->make();
    }

}
