<?php

namespace App\Exports;

use App\Models\PaymentProof;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PaymentProofsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return PaymentProof::with(['user', 'transactions'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama File',
            'Ukuran File',
            'Status',
            'User',
            'Pembayar',
            'Tanggal Upload',
            'URL File'
        ];
    }

    public function map($proof): array
    {
        $payerName = explode(' - ', $proof->transactions->first()->description ?? '')[0] ?? $proof->user->name;

        return [
            $proof->id,
            $proof->file_name,
            $proof->formatted_file_size,
            $proof->status === 'approved' ? 'Disetujui' : ($proof->status === 'pending' ? 'Pending' : 'Ditolak'),
            $proof->user->name,
            $payerName,
            $proof->created_at->format('d/m/Y H:i:s'),
            $proof->file_url
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 30,  // Nama File
            'C' => 15,  // Ukuran File
            'D' => 12,  // Status
            'E' => 20,  // User
            'F' => 20,  // Pembayar
            'G' => 18,  // Tanggal Upload
            'H' => 50,  // URL File
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Style header row
                $headerRange = 'A1:H1';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '059669'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Style data rows
                $dataRange = 'A2:H' . ($sheet->getHighestRow());
                $sheet->getStyle($dataRange)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CCCCCC'],
                        ],
                    ],
                ]);

                // Auto-fit row height
                foreach ($sheet->getRowIterator() as $row) {
                    $sheet->getRowDimension($row->getRowIndex())->setRowHeight(20);
                }

                // Freeze header row
                $sheet->freezePane('A2');
            },
        ];
    }
}
