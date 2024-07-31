<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\TrashData;
use App\Models\TrashType;
use App\Exports\TrashExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    public function reportData() {
        $year = request('y');
        $month = request('m');
        $types = ['all', 'organic', 'anorganic', 'recyclable'];
        $dataResults = [];
    
        foreach ($types as $type) {
            $typeIds = TrashType::where('type', $type)->pluck('id')->toArray();
    
            $query = TrashData::whereIn('trash_type_id', $typeIds);
    
            if ($year && $month) {
                $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
                $selectRaw = 'YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, CAST(SUM(weight) AS UNSIGNED) as total_weight';
                $groupBy = ['year', 'month', 'day'];
            } elseif ($year) {
                $query->whereYear('created_at', $year);
                $selectRaw = 'YEAR(created_at) as year, MONTH(created_at) as month, CAST(SUM(weight) AS UNSIGNED) as total_weight';
                $groupBy = ['year', 'month'];
            } elseif ($month) {
                $currentYear = date('Y');
                $query->whereYear('created_at', $currentYear)->whereMonth('created_at', $month);
                $selectRaw = 'YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, CAST(SUM(weight) AS UNSIGNED) as total_weight';
                $groupBy = ['year', 'month', 'day'];
            } else {
                $selectRaw = 'YEAR(created_at) as year, MONTH(created_at) as month, CAST(SUM(weight) AS UNSIGNED) as total_weight';
                $groupBy = ['year', 'month'];
            }
    
            $query->selectRaw($selectRaw)->groupBy($groupBy);
    
            $dataResults[$type] = $query->get();
        }
    
        // dd($dataResults['all']);
            // Akumulasi total berat 'all' untuk periode yang dipilih
        $totalAll = $dataResults['all']->sum('total_weight');

        // Hitung Persentase
        $percentages = [];
        foreach (['organic', 'anorganic', 'recyclable'] as $type) {
            $totalType = $dataResults[$type]->sum('total_weight');
            $percentages[$type] = $totalAll > 0 ? ($totalType / $totalAll * 100) : 0;
        }
    
        return Helper::successMessage(data: ['totals' => $dataResults, 'percentages' => $percentages]);
    }

    public function exportExcel(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $exportName = 'export_trash_' . ($tahun ?? 'all') . '_' . ($bulan ?? 'all') . '.xls';
        $exportPath = 'exports/' . $exportName;

        Excel::store(new TrashExport($tahun, $bulan), $exportPath, 'public');


        $downloadUrl = Storage::disk('public')->url($exportPath);
        return Helper::successMessage("Berhasil membuat file", ['download_url' => $downloadUrl]);
    }
}
