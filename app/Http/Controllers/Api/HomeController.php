<?php

namespace App\Http\Controllers\api;

use App\Helpers\Helper;
use App\Models\TrashData;
use App\Models\TrashType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $typeAll = TrashType::where('type', 'all')->pluck('id');
            $chartData = TrashData::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(weight) as total_weight')
            ->where('trash_type_id', $typeAll)
            ->groupBy('year', 'month')->get();
    
            $listYears = TrashData::where('trash_type_id', $typeAll)->pluck('created_at')->map(function ($date) {
                return $date->format('Y');
            });
    
            $yearsColl = $listYears->unique();
    
            foreach ($yearsColl as $data) {
                $years[] = (int)$data;
            }
    
            $typeRecyclable = TrashType::where('type', 'recyclable')->pluck('id');
            $typeOrganic = TrashType::where('type', 'organic')->pluck('id');
            $typeAnorganic = TrashType::where('type', 'anorganic')->pluck('id');
            $allTypeSum = TrashData::where('trash_type_id', $typeAll)->sum('weight');
            $recyclableTypeSum = TrashData::where('trash_type_id', $typeRecyclable)->sum('weight');
            $organicTypeSum = TrashData::where('trash_type_id', $typeOrganic)->sum('weight');
            $anorganicTypeSum = TrashData::where('trash_type_id', $typeAnorganic)->sum('weight');
    
            return Helper::successMessage("Berhasil get data", [
                'recyclable' => $recyclableTypeSum,
                'organic' => $organicTypeSum,
                'anorganic' => $anorganicTypeSum,
                'all' => $allTypeSum,
                'years' => $years,
                'chart_datas' => $chartData,
            ]);
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
    public function show(string $id)
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
}
