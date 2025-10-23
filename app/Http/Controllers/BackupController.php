<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Tasks\Backup\BackupJob;
use App\Models\Transaction;
use App\Models\PaymentProof;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Exports\PaymentProofsExport;
use App\Exports\UsersExport;
use App\Exports\WeeklyPaymentsExport;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage_settings');
    }

    public function index()
    {
        // Find all backup files
        $backupFiles = [];
        $possibleDirs = [
            storage_path('app/backups/'),
            storage_path('app/private/kas-management/'),
            storage_path('app/kas-management/'),
        ];

        foreach ($possibleDirs as $dir) {
            if (is_dir($dir)) {
                $files = glob($dir . '*.zip');
                foreach ($files as $file) {
                    $backupFiles[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => filesize($file),
                        'date' => filemtime($file),
                        'size_formatted' => $this->formatFileSize(filesize($file)),
                        'date_formatted' => date('d/m/Y H:i:s', filemtime($file)),
                    ];
                }
            }
        }

        // Sort by date (newest first)
        usort($backupFiles, function($a, $b) {
            return $b['date'] - $a['date'];
        });

        return view('backup.index', compact('backupFiles'));
    }

    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    public function createBackup()
    {
        try {
            Artisan::call('backup:run');

            return redirect()->route('backup.index')
                ->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->route('backup.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function downloadBackup($filename)
    {
        // Try different backup locations
        $possiblePaths = [
            storage_path('app/backups/' . $filename),
            storage_path('app/private/kas-management/' . $filename),
            storage_path('app/kas-management/' . $filename),
        ];

        $backupPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $backupPath = $path;
                break;
            }
        }

        if (!$backupPath) {
            // If filename is 'latest', try to find the most recent backup
            if ($filename === 'latest') {
                $backupPath = $this->findLatestBackup();
            }

            if (!$backupPath) {
                return redirect()->route('backup.index')
                    ->with('error', 'File backup tidak ditemukan!');
            }
        }

        return Response::download($backupPath);
    }

    private function findLatestBackup()
    {
        $possibleDirs = [
            storage_path('app/backups/'),
            storage_path('app/private/kas-management/'),
            storage_path('app/kas-management/'),
        ];

        $latestFile = null;
        $latestTime = 0;

        foreach ($possibleDirs as $dir) {
            if (is_dir($dir)) {
                $files = glob($dir . '*.zip');
                foreach ($files as $file) {
                    if (filemtime($file) > $latestTime) {
                        $latestTime = filemtime($file);
                        $latestFile = $file;
                    }
                }
            }
        }

        return $latestFile;
    }

    public function exportTransactions()
    {
        return Excel::download(new TransactionsExport, 'transactions_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportPaymentProofs()
    {
        return Excel::download(new PaymentProofsExport, 'payment_proofs_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportWeeklyPayments()
    {
        return Excel::download(new WeeklyPaymentsExport, 'weekly_payments_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportAll()
    {
        return Excel::download(new class implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
            public function sheets(): array
            {
                return [
                    'Transactions' => new TransactionsExport,
                    'Payment Proofs' => new PaymentProofsExport,
                    'Users' => new UsersExport,
                    'Weekly Payments' => new WeeklyPaymentsExport,
                ];
            }
        }, 'all_data_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
