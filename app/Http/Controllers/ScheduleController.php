<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MetaDate;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metaDateIds = Schedule::pluck('meta_date_id');

        $latestMetaData = MetaDate::whereIn('id', $metaDateIds)->oldest('date')->first();

        if ($latestMetaData) {
            $latestMetaDataDate = Carbon::parse($latestMetaData->date)->timezone('Asia/Jakarta');
            $today = Carbon::now('Asia/Jakarta');
            
            $sevenDaysAhead = $latestMetaDataDate->copy()->addDays(6)->startOfDay();
            
            $isPastWeek = $today > $sevenDaysAhead;
        } else {
            $isPastWeek = false;
        }

        // Menginisialisasi variabel $null
        $null = $metaDateIds->isEmpty();

        // Pass both $isPastWeek and $null to the view
        return view('contents.schedule.index', compact('isPastWeek', 'null'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua tanggal dari MetaDate
        $dates = MetaDate::all();

        // Mengambil semua tanggal yang belum ada di tabel Schedule
        $availableDates = [];
        foreach ($dates as $date) {
            if (!Schedule::where('meta_date_id', $date->id)->exists()) {
                $availableDates[] = $date;
            }
        }

        // Mengubah format tanggal
        foreach ($availableDates as $date) {
            $date->tanggal = substr($date->date, 8, 2);
        }

        // Mengurutkan koleksi berdasarkan tanggal
        $availableDates = collect($availableDates)->sortBy('tanggal');

        return view('contents.schedule.create', compact('availableDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'time' => 'required|date_format:H:i',
        ]);

        // Ambil waktu yang dipilih dari input
        $time = $request->input('time');

        // Ambil semua meta_date_id dari tabel meta_dates
        $metaDateIds = MetaDate::pluck('id');

        // Lakukan operasi penyimpanan data schedule untuk setiap meta_date_id
        foreach ($metaDateIds as $metaDateId) {
            Schedule::create([
                'user_id' => Auth::user()->id,
                'meta_date_id' => $metaDateId,
                'start_time' => $time,
                'is_active' => true,
                // Tambahkan kolom lain yang perlu disimpan di sini
            ]);
        }

        // Tambahkan respon atau pengalihan ke halaman yang sesuai setelah penyimpanan berhasil
        return redirect()->route('schedule.index')->with('success', 'Schedule reset successfully!');
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
        // $data['schedule'] = Schedule::find($id);

        // // Mengambil semua tanggal dari MetaDate
        // $dates = MetaDate::all();

        // // Mengambil semua tanggal yang belum ada di tabel Schedule
        // $availableDates = [];
        // foreach ($dates as $date) {
        //     if (!Schedule::where('meta_date_id', $date->id)->exists()) {
        //         $availableDates[] = $date;
        //     }
        // }

        // // Mengubah format tanggal
        // foreach ($availableDates as $date) {
        //     $date->tanggal = substr($date->date, 8, 2);
        // }

        // // Mengurutkan koleksi berdasarkan tanggal
        // $availableDates = collect($availableDates)->sortBy('tanggal');

        // return view('contents.schedule.edit', $data, compact('availableDates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // // Validasi data yang diterima dari formulir
        // $validator = Validator::make($request->all(), [
        //     'date'   => 'required',
        //     'time'   => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // DB::beginTransaction();

        // try {
        //     // Temukan entitas yang akan diperbarui berdasarkan ID
        //     $schedule = Schedule::find($id);

        //     // Perbarui nilai atribut entitas
        //     $schedule->meta_date_id = $request->date;
        //     $schedule->start_time = $request->time;

        //     // Simpan perubahan ke dalam database
        //     $schedule->save();

        //     DB::commit();

        //     return redirect()->route('schedule.index')->with('success', 'Data berhasil diupdate.');
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        // }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {    

            Schedule::find($id)->delete();

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(),]);
        }
    
        return response()->json(['status' => true, 'message' => 'Berhasil menghapus jadwal!',]);
    }

    public function datatable(Request $request)
    {
        $data = Schedule::with('date', 'user.userData')->get();

        // dd($data);

        return DataTables::of($data)->make();
    }

    public function isActive(Request $request)
    {
        // dd($request);
        $Schedule = Schedule::find($request->id);

        if ($Schedule) {
            $Schedule->update([
                'is_active' => $request->state,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Success Update Data!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found!',
            ], 404); // or handle the situation according to your requirements
        }
    }
}
