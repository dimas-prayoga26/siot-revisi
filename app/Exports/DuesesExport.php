<?php

namespace App\Exports;

use App\Models\Dueses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DuesesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Dueses::with('user.userData', 'metaDuesNominal')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Masyarakat',
            'Nominal',
            'Status',
        ];
    }

    public function map($dues): array
    {
        return [
            $dues->user->userData->name ?? 'Belum Ada Data!',
            'Rp. ' . number_format($dues->metaDuesNominal->nominal, 0, ',', '.'),
            $dues->is_paid ? 'Sudah Di Bayar' : 'Belum Di Bayar',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Merge cells for header
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');

        // Optionally set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
    }
}
