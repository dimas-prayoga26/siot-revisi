<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use League\Csv\Writer;
use SplTempFileObject;
use App\Models\UserData;
use App\Models\TrashData;
use App\Models\TrashType;
use App\Exports\TrashExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DashboardController extends Controller
{

    protected $excel;

public function __construct(Excel $excel)
{
    $this->excel = $excel;
}

public function index()
{
    $years = TrashData::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    $monthsCreated_at = TrashData::selectRaw("MONTH(created_at) as month")
        ->distinct()
        ->orderByRaw("MONTH(created_at)")
        ->pluck('month')
        ->map(function ($month) {
            return date('M', strtotime(date('Y') . '-' . $month . '-01'));
        });

    $trashTypes = TrashType::all();
    $weightsByType = [];
    
    $currentYear = Carbon::now()->year;
    $currentMonth = Carbon::now()->month;
    $currentDay = Carbon::now('Asia/Jakarta')->day;
    
    foreach ($trashTypes as $type) {
        $weight = TrashData::where('trash_type_id', $type->id)
            ->whereDate('created_at', Carbon::create($currentYear, $currentMonth, $currentDay))
            ->sum('weight');
        
        $weightsByType[$type->type] = number_format($weight, 2, '.', '');
    }
    
    $weightsByTypeAnorganic = $weightsByType['anorganic'] ?? '0.00';
    $weightsByTypeOrganic = $weightsByType['organic'] ?? '0.00';
    $weightsByTypeRecyclable = $weightsByType['recyclable'] ?? '0.00';
    $weightsByTypeAll = $weightsByType['all'] ?? '0.00';

    return view('contents.dashboard', compact('weightsByTypeAnorganic', 'weightsByTypeOrganic', 'weightsByTypeRecyclable', 'weightsByTypeAll', 'years', 'monthsCreated_at'));
}

public function chartData(Request $request)
{
    $tahun = $request->tahun ?? null;
    $bulan = $request->bulan ? Carbon::parse($request->bulan)->month : null;
    $trashTypes = TrashType::all();
    $weightsByType = [];
    $date12MonthsAgo = Carbon::now()->subMonths(11);

    if ($tahun && $bulan) {
        $daysInMonth = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            foreach ($trashTypes as $type) {
                $weight = TrashData::where('trash_type_id', $type->id)
                    ->whereDate('created_at', Carbon::create($tahun, $bulan, $day))
                    ->sum('weight');
                
                $weightsByType[$type->type][$day] = number_format($weight, 2, '.', ''); // Menyimpan nilai dengan dua desimal
            }
        }
    } elseif ($tahun) {
        for ($month = 1; $month <= 12; $month++) {
            $currentMonthName = Carbon::create()->month($month)->format('M');

            foreach ($trashTypes as $type) {
                $weightsByType[$type->type][$currentMonthName] = '0.00';
            }

            foreach ($trashTypes as $type) {
                $weight = TrashData::where('trash_type_id', $type->id)
                    ->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $month)
                    ->sum('weight');

                $weightsByType[$type->type][$currentMonthName] = number_format($weight, 2, '.', ''); // Menyimpan nilai dengan dua desimal
            }
        }
    } else {
        $daysInMonth = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            foreach ($trashTypes as $type) {
                $weight = TrashData::where('trash_type_id', $type->id)
                    ->whereDate('created_at', Carbon::create($tahun, $bulan, $day))
                    ->sum('weight');
                
                $weightsByType[$type->type][$day] = number_format($weight, 2, '.', ''); // Menyimpan nilai dengan dua desimal
            }
        }
    }

    return response()->json([
        'data' => [
            'chartDataAnorganic' => $weightsByType['anorganic'] ?? [],
            'chartDataOrganic' => $weightsByType['organic'] ?? [],
            'chartDataRecylable' => $weightsByType['recyclable'] ?? [],
            'chartDataTypeAll' => $weightsByType['all'] ?? []
        ]
    ]);
}



    // public function fetchData(Request $request)
    // {
    //     dd($request);
    //     $today = Carbon::today();

    //     $trashTypes = TrashType::all();
    //     $weightsByType = [];

    //     foreach ($trashTypes as $type) {
    //         $weight = TrashData::where('trash_type_id', $type->id)
    //             ->whereDate('created_at', $today)
    //             ->sum('weight');
            
    //         // Tambahkan "kg" setelah nilai berat
    //         $weightsByType[$type->type] = $weight . ' kg';
    //     }

    //     return response()->json([
    //         'weightsByTypeOrganic' => $weightsByType['organic'] ?? '0 kg',
    //         'weightsByTypeAnorganic' => $weightsByType['anorganic'] ?? '0 kg',
    //         'weightsByTypeRecyclable' => $weightsByType['recyclable'] ?? '0 kg',
    //         'weightsByTypeAll' => $weightsByType['all'] ?? '0 kg',
    //     ]);
    // }

    public function exportExcel(Request $request)
{
    $currentDate = Carbon::now();
    
    // Ambil input dari request, atau gunakan tahun dan bulan saat ini jika tidak ada input
    $tahun = $request->input('tahun');
    $bulan = $request->input('bulan');
    
    if (is_null($bulan) && is_null($tahun)) {
        // Jika baik bulan maupun tahun tidak dipilih, gunakan tahun dan bulan saat ini
        $tahun = $currentDate->year;
        $bulan = $currentDate->month;
        $fileName = 'laporan_data_berat_sampah_' . $tahun . '_' . $bulan . '.xlsx';
    } elseif (is_null($bulan)) {
        // Jika hanya bulan yang null, hanya cantumkan tahun di nama file
        $fileName = 'laporan_data_berat_sampah_' . $tahun . '.xlsx';
    } else {
        // Jika bulan ada, pastikan format bulan benar dan buat nama file yang mencantumkan bulan dan tahun
        $bulan = Carbon::parse($bulan)->month;
        $fileName = 'laporan_data_berat_sampah_' . $tahun . '_' . $bulan . '.xlsx';
    }

    // Ekspor data menggunakan nama file yang ditentukan
    return $this->excel->download(new TrashExport($tahun, $bulan), $fileName);
}




}
