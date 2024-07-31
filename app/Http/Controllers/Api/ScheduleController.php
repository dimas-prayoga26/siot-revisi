<?php

namespace App\Http\Controllers\api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Helper::successMessage('Berhasil get data', Schedule::with('date')->get());
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
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
    public function getByUserId(string $id)
    {
        try {
            return Helper::successMessage('Berhasil get data', Schedule::where('user_id',$id)->with('date')->get());
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }


    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Schedule::find($id)->update([
                'start_time' => $request->start_time,
                'is_active' => $request->is_active,
            ]);

            return Helper::successMessage('Berhasil mengubah jadwal pengangkutan');
        } catch (\Throwable $th) {
            return Helper::internalServerErrorMessage($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
