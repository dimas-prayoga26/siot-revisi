<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use App\Models\TrashType;
use App\Models\TrashData;

class TrashExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun = null, $bulan = null)
    {
        $currentDate = Carbon::now();

        // Jika dua pilihan null, gunakan bulan dan tahun saat ini
        if (is_null($tahun) && is_null($bulan)) {
            $this->tahun = $currentDate->year;
            $this->bulan = $currentDate->month;
        } else {
            // Jika salah satu parameter diisi, gunakan sesuai input
            $this->tahun = $tahun ?: $currentDate->year;
            $this->bulan = $bulan;
        }
    }

    public function collection()
    {
        // Urutan kolom yang diinginkan
        $desiredOrder = ['Organik', 'Anorganik', 'Recyclable', 'All'];
        // Array nama bulan
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Ambil data TrashType dan urutkan sesuai urutan yang diinginkan
        $trashTypes = TrashType::whereIn('type', ['anorganic', 'all', 'recyclable', 'organic'])->get();

        // Atur trashTypes sesuai urutan yang diinginkan
        $trashTypes = $trashTypes->sortBy(function ($item) use ($desiredOrder) {
            return array_search(ucfirst($item->type), $desiredOrder);
        });

        $data = collect();

        if (!is_null($this->bulan)) {
            // Jika bulan tidak null, data berdasarkan bulan
            $daysInMonth = Carbon::createFromDate($this->tahun, $this->bulan)->daysInMonth;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $row = ['Hari' => $day];
                foreach ($trashTypes as $type) {
                    $weight = TrashData::where('trash_type_id', $type->id)
                        ->whereDate('created_at', Carbon::create($this->tahun, $this->bulan, $day))
                        ->sum('weight');

                    // Tambahkan "KG" hanya jika nilainya bukan nol
                    $row[ucfirst($type->type)] = $weight > 0 ? "{$weight} KG" : 0;
                }
                $data->push($row);
            }
        } else {
            // Jika bulan null, data berdasarkan tahun
            for ($month = 1; $month <= 12; $month++) {
                $row = ['Bulan' => $monthNames[$month]];
                foreach ($trashTypes as  $type) {
                    $weight = TrashData::where('trash_type_id', $type->id)
                        ->whereYear('created_at', $this->tahun)
                        ->whereMonth('created_at', $month)
                        ->sum('weight');

                    // Tambahkan "KG" hanya jika nilainya bukan nol
                    $row[ucfirst($type->type)] = $weight > 0 ? "{$weight} KG" : 0;
                }
                $data->push($row);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        if (!is_null($this->bulan)) {
            return ['Hari', 'Organik', 'Anorganik', 'Recyclable', 'All'];
        } else {
            return ['Bulan', 'Organik', 'Anorganik', 'Recyclable', 'All'];
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => ['font' => ['bold' => true]],
            // Align text to center for all columns
            'A' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'E' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
        ];
    }
}
