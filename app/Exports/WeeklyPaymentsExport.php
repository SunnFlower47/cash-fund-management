<?php

namespace App\Exports;

use App\Models\WeeklyPayment;
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

class WeeklyPaymentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        if ($this->data) {
            return $this->data;
        }

        return WeeklyPayment::with('user')->orderBy('week_period')->orderBy('user_id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Periode',
            'Nama Anggota',
            'Email',
            'Jumlah Tagihan',
            'Status',
            'Tanggal Bayar',
            'Catatan',
            'Tanggal Dibuat',
            'Tanggal Diperbarui'
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->week_period_display,
            $payment->user->name,
            $payment->user->email,
            'Rp ' . number_format($payment->amount, 0, ',', '.'),
            $payment->is_paid ? 'Lunas' : 'Belum Bayar',
            $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i:s') : '-',
            $payment->notes ?? '-',
            $payment->created_at->format('d/m/Y H:i:s'),
            $payment->updated_at->format('d/m/Y H:i:s')
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 20,  // Periode
            'C' => 20,  // Nama Anggota
            'D' => 25,  // Email
            'E' => 15,  // Jumlah Tagihan
            'F' => 12,  // Status
            'G' => 18,  // Tanggal Bayar
            'H' => 30,  // Catatan
            'I' => 18,  // Tanggal Dibuat
            'J' => 18,  // Tanggal Diperbarui
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
                    'startColor' => ['rgb' => '10B981'], // Teal color
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
                $headerRange = 'A1:J1';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '10B981'], // Teal color
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

                // Style data rows with different colors for paid/unpaid
                $dataRange = 'A2:J' . ($sheet->getHighestRow());
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

                // Apply different background colors based on payment status
                $row = 2;
                foreach ($sheet->getRowIterator(2) as $row) {
                    $rowIndex = $row->getRowIndex();
                    $statusCell = 'F' . $rowIndex; // Column F contains the status
                    $statusValue = $sheet->getCell($statusCell)->getValue();

                    if ($statusValue === 'Lunas') {
                        // Green background for paid
                        $sheet->getStyle('A' . $rowIndex . ':J' . $rowIndex)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F0FDF4'], // Light green
                            ],
                        ]);

                        // Green text for amount column (E)
                        $sheet->getStyle('E' . $rowIndex)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '059669'], // Dark green
                                'bold' => true,
                            ],
                        ]);

                        // Style status column (F) for paid
                        $sheet->getStyle($statusCell)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '059669'], // Dark green
                                'bold' => true,
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'DCFCE7'], // Light green
                            ],
                        ]);
                    } elseif ($statusValue === 'Belum Bayar') {
                        // Red background for unpaid
                        $sheet->getStyle('A' . $rowIndex . ':J' . $rowIndex)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FEF2F2'], // Light red
                            ],
                        ]);

                        // Red text for amount column (E)
                        $sheet->getStyle('E' . $rowIndex)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => 'DC2626'], // Dark red
                                'bold' => true,
                            ],
                        ]);

                        // Style status column (F) for unpaid
                        $sheet->getStyle($statusCell)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => 'DC2626'], // Dark red
                                'bold' => true,
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FEE2E2'], // Light red
                            ],
                        ]);
                    }
                }

                // Auto-fit row height
                foreach ($sheet->getRowIterator() as $row) {
                    $sheet->getRowDimension($row->getRowIndex())->setRowHeight(20);
                }

                // Freeze header row
                $sheet->freezePane('A2');

                // Add summary section
                $this->addSummarySection($sheet);
            },
        ];
    }

    private function addSummarySection($sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $summaryStartRow = $lastRow + 3;

        // Add summary title
        $sheet->setCellValue('A' . $summaryStartRow, 'SUMMARY KAS MINGGUAN');
        $sheet->getStyle('A' . $summaryStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F2937'], // Dark gray
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->mergeCells('A' . $summaryStartRow . ':J' . $summaryStartRow);

        // Calculate totals
        $totalPaid = 0;
        $totalUnpaid = 0;
        $paidCount = 0;
        $unpaidCount = 0;
        $totalAmount = 0;

        for ($row = 2; $row <= $lastRow; $row++) {
            $statusCell = 'F' . $row;
            $amountCell = 'E' . $row;
            $statusValue = $sheet->getCell($statusCell)->getValue();
            $amountValue = $sheet->getCell($amountCell)->getValue();

            // Extract numeric value from amount (remove "Rp " and commas)
            $numericAmount = (float) str_replace(['Rp ', ',', '.'], '', $amountValue);
            $totalAmount += $numericAmount;

            if ($statusValue === 'Lunas') {
                $totalPaid += $numericAmount;
                $paidCount++;
            } elseif ($statusValue === 'Belum Bayar') {
                $totalUnpaid += $numericAmount;
                $unpaidCount++;
            }
        }

        // Add summary data
        $summaryData = [
            ['Kategori', 'Jumlah Tagihan', 'Total (Rp)', 'Persentase'],
            ['Sudah Lunas', $paidCount, 'Rp ' . number_format($totalPaid, 0, ',', '.'), $totalAmount > 0 ? round(($totalPaid / $totalAmount) * 100, 1) . '%' : '0%'],
            ['Belum Lunas', $unpaidCount, 'Rp ' . number_format($totalUnpaid, 0, ',', '.'), $totalAmount > 0 ? round(($totalUnpaid / $totalAmount) * 100, 1) . '%' : '0%'],
            ['TOTAL TAGIHAN', $paidCount + $unpaidCount, 'Rp ' . number_format($totalAmount, 0, ',', '.'), '100%'],
        ];

        $currentRow = $summaryStartRow + 2;
        foreach ($summaryData as $index => $rowData) {
            $sheet->setCellValue('A' . $currentRow, $rowData[0]);
            $sheet->setCellValue('B' . $currentRow, $rowData[1]);
            $sheet->setCellValue('C' . $currentRow, $rowData[2]);
            $sheet->setCellValue('D' . $currentRow, $rowData[3]);

            // Style summary rows
            if ($index === 0) {
                // Header row
                $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '10B981'], // Teal color
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
            } elseif ($index === 1) {
                // Paid row
                $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '059669'], // Dark green
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F0FDF4'], // Light green
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
            } elseif ($index === 2) {
                // Unpaid row
                $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'DC2626'], // Dark red
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FEF2F2'], // Light red
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
            } elseif ($index === 3) {
                // Total row
                $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => '1F2937'], // Dark gray
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6'], // Light gray
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            }

            $currentRow++;
        }

        // Set column widths for summary
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(12);
    }
}
