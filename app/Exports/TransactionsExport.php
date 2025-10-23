<?php

namespace App\Exports;

use App\Models\Transaction;
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

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return Transaction::with(['user', 'approver'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Jenis',
            'Jumlah',
            'Deskripsi',
            'Sumber',
            'Status',
            'User',
            'Approver',
            'Tanggal Dibuat',
            'Tanggal Disetujui',
            'Catatan'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
            'Rp ' . number_format($transaction->amount, 0, ',', '.'),
            $transaction->description,
            $transaction->source ?? '-',
            $transaction->status === 'approved' ? 'Disetujui' : ($transaction->status === 'pending' ? 'Pending' : 'Ditolak'),
            $transaction->user->name,
            $transaction->approver ? $transaction->approver->name : '-',
            $transaction->created_at->format('d/m/Y H:i:s'),
            $transaction->approved_at ? $transaction->approved_at->format('d/m/Y H:i:s') : '-',
            $transaction->notes ?? '-'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 12,  // Jenis
            'C' => 15,  // Jumlah
            'D' => 30,  // Deskripsi
            'E' => 20,  // Sumber
            'F' => 12,  // Status
            'G' => 20,  // User
            'H' => 20,  // Approver
            'I' => 18,  // Tanggal Dibuat
            'J' => 18,  // Tanggal Disetujui
            'K' => 30,  // Catatan
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
                    'startColor' => ['rgb' => '4F46E5'],
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
                $headerRange = 'A1:K1';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F46E5'],
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

                // Style data rows with different colors for income/expense
                $dataRange = 'A2:K' . ($sheet->getHighestRow());
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

                // Apply different background colors based on transaction type
                $row = 2;
                foreach ($sheet->getRowIterator(2) as $row) {
                    $rowIndex = $row->getRowIndex();
                    $typeCell = 'B' . $rowIndex; // Column B contains the type
                    $typeValue = $sheet->getCell($typeCell)->getValue();

                    if ($typeValue === 'Pemasukan') {
                        // Green background for income
                        $sheet->getStyle('A' . $rowIndex . ':K' . $rowIndex)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F0FDF4'], // Light green
                            ],
                        ]);

                        // Green text for amount column (C)
                        $sheet->getStyle('C' . $rowIndex)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '059669'], // Dark green
                                'bold' => true,
                            ],
                        ]);

                        // Style status column (F) for income
                        $statusCell = 'F' . $rowIndex;
                        $statusValue = $sheet->getCell($statusCell)->getValue();
                        if ($statusValue === 'Disetujui') {
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
                        }
                    } elseif ($typeValue === 'Pengeluaran') {
                        // Red background for expense
                        $sheet->getStyle('A' . $rowIndex . ':K' . $rowIndex)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FEF2F2'], // Light red
                            ],
                        ]);

                        // Red text for amount column (C)
                        $sheet->getStyle('C' . $rowIndex)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => 'DC2626'], // Dark red
                                'bold' => true,
                            ],
                        ]);

                        // Style status column (F) for expense
                        $statusCell = 'F' . $rowIndex;
                        $statusValue = $sheet->getCell($statusCell)->getValue();
                        if ($statusValue === 'Disetujui') {
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
                        } elseif ($statusValue === 'Pending') {
                            $sheet->getStyle($statusCell)->applyFromArray([
                                'font' => [
                                    'color' => ['rgb' => 'D97706'], // Dark orange
                                    'bold' => true,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'FEF3C7'], // Light orange
                                ],
                            ]);
                        } elseif ($statusValue === 'Ditolak') {
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
        $sheet->setCellValue('A' . $summaryStartRow, 'SUMMARY');
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
        $sheet->mergeCells('A' . $summaryStartRow . ':K' . $summaryStartRow);

        // Calculate totals
        $totalIncome = 0;
        $totalExpense = 0;
        $incomeCount = 0;
        $expenseCount = 0;

        for ($row = 2; $row <= $lastRow; $row++) {
            $typeCell = 'B' . $row;
            $amountCell = 'C' . $row;
            $typeValue = $sheet->getCell($typeCell)->getValue();
            $amountValue = $sheet->getCell($amountCell)->getValue();

            // Extract numeric value from amount (remove "Rp " and commas)
            $numericAmount = (float) str_replace(['Rp ', ',', '.'], '', $amountValue);

            if ($typeValue === 'Pemasukan') {
                $totalIncome += $numericAmount;
                $incomeCount++;
            } elseif ($typeValue === 'Pengeluaran') {
                $totalExpense += $numericAmount;
                $expenseCount++;
            }
        }

        $netTotal = $totalIncome - $totalExpense;

        // Add summary data
        $summaryData = [
            ['Kategori', 'Jumlah Transaksi', 'Total (Rp)'],
            ['Pemasukan', $incomeCount, 'Rp ' . number_format($totalIncome, 0, ',', '.')],
            ['Pengeluaran', $expenseCount, 'Rp ' . number_format($totalExpense, 0, ',', '.')],
            ['SALDO BERSIH', '', 'Rp ' . number_format($netTotal, 0, ',', '.')],
        ];

        $currentRow = $summaryStartRow + 2;
        foreach ($summaryData as $index => $rowData) {
            $sheet->setCellValue('A' . $currentRow, $rowData[0]);
            $sheet->setCellValue('B' . $currentRow, $rowData[1]);
            $sheet->setCellValue('C' . $currentRow, $rowData[2]);

            // Style summary rows
            if ($index === 0) {
                // Header row
                $sheet->getStyle('A' . $currentRow . ':C' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F46E5'], // Purple
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
                // Income row
                $sheet->getStyle('A' . $currentRow . ':C' . $currentRow)->applyFromArray([
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
                // Expense row
                $sheet->getStyle('A' . $currentRow . ':C' . $currentRow)->applyFromArray([
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
                // Net total row
                $netColor = $netTotal >= 0 ? '059669' : 'DC2626'; // Green if positive, red if negative
                $netBgColor = $netTotal >= 0 ? 'F0FDF4' : 'FEF2F2'; // Light green if positive, light red if negative

                $sheet->getStyle('A' . $currentRow . ':C' . $currentRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => $netColor],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $netBgColor],
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
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
    }
}
