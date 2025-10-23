<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeeklyPayment;
use App\Models\Transaction;
use App\Models\CashBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklyPaymentsExport;

class WeeklyPaymentController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_weekly_payments');

        $selectedPeriod = $request->get('period');
        $selectedYear = $request->get('year', now()->format('Y'));
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $selectedWeek = $request->get('week');
        $selectedUser = $request->get('user_id');


        $periods = $this->getAvailablePeriods();
        $years = $this->getAvailableYears();

        // Get months based on selected year
        if ($selectedYear) {
            $months = $this->getAvailableMonthsForYear($selectedYear);
        } else {
            $months = $this->getAvailableMonths();
        }

        $users = User::role('anggota')->get();

        $query = WeeklyPayment::with('user');

        // Filter by year, month and week
        if ($selectedYear) {
            if ($selectedMonth) {
                if ($selectedWeek) {
                    $query->where('week_period', $selectedMonth . '-W' . $selectedWeek);
                } else {
                    $query->where('week_period', 'like', $selectedMonth . '%');
                }
            } else {
                $query->where('week_period', 'like', $selectedYear . '%');
            }
        } else {
            // If no year selected, filter by month if specified
            if ($selectedMonth) {
                if ($selectedWeek) {
                    $query->where('week_period', $selectedMonth . '-W' . $selectedWeek);
                } else {
                    $query->where('week_period', 'like', $selectedMonth . '%');
                }
            }
        }

        // Filter by user if specified
        if ($selectedUser) {
            $query->where('user_id', $selectedUser);
        }

        $weeklyPayments = $query->orderBy('week_period')->orderBy('user_id')->get();


        return view('weekly-payments.index', compact(
            'weeklyPayments',
            'periods',
            'years',
            'months',
            'users',
            'selectedPeriod',
            'selectedYear',
            'selectedMonth',
            'selectedWeek',
            'selectedUser'
        ));
    }

    public function generate(Request $request)
    {
        $this->authorize('manage_weekly_payments');

        $request->validate([
            'year' => 'required|string',
            'month' => 'required|string',
            'week' => 'nullable|integer|min:1|max:4',
            'amount' => 'required|numeric|min:0'
        ]);

        $selectedYear = $request->year;
        $selectedMonth = $request->month;
        $amount = $request->input('amount', 50000);

        // Get all users with 'anggota' role
        $users = User::role('anggota')->get();

        if ($request->has('week') && $request->week) {
            // Generate for specific week
            $weekPeriod = $selectedMonth . '-W' . $request->week;

            foreach ($users as $user) {
                WeeklyPayment::updateOrCreate(
                    [
                        'week_period' => $weekPeriod,
                        'user_id' => $user->id
                    ],
                    [
                        'amount' => $amount,
                        'is_paid' => false,
                        'paid_at' => null
                    ]
                );
            }

            return redirect()->route('weekly-payments.index', ['period' => $weekPeriod])
                ->with('success', 'Tagihan mingguan berhasil dibuat untuk ' . $this->getWeekPeriodDisplay($weekPeriod) . '!');
        } else {
            // Generate for all weeks (1-4)
            $generatedPeriods = [];

            for ($week = 1; $week <= 4; $week++) {
                $weekPeriod = $selectedMonth . '-W' . $week;

                foreach ($users as $user) {
                    WeeklyPayment::updateOrCreate(
                        [
                            'week_period' => $weekPeriod,
                            'user_id' => $user->id
                        ],
                        [
                            'amount' => $amount,
                            'is_paid' => false,
                            'paid_at' => null
                        ]
                    );
                }

                $generatedPeriods[] = $this->getWeekPeriodDisplay($weekPeriod);
            }

            return redirect()->route('weekly-payments.index', ['month' => $selectedMonth])
                ->with('success', 'Tagihan mingguan berhasil dibuat untuk semua minggu dalam ' . $this->getMonthDisplay($selectedMonth) . '! (' . implode(', ', $generatedPeriods) . ')');
        }
    }

    private function getWeekPeriodDisplay($weekPeriod): string
    {
        $parts = explode('-', $weekPeriod);
        if (count($parts) >= 3) {
            $year = $parts[0];
            $month = $parts[1];
            $week = str_replace('W', '', $parts[2]); // Remove 'W' prefix from week

            $monthNames = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ];

            return "Minggu {$week} {$monthNames[$month]} {$year}";
        }

        return $weekPeriod;
    }

    public function markAsPaid(Request $request, WeeklyPayment $weeklyPayment)
    {
        $this->authorize('manage_weekly_payments');

        $weeklyPayment->update([
            'is_paid' => true,
            'paid_at' => now(),
            'notes' => $request->input('notes')
        ]);

        // Create transaction record for the payment
        Transaction::create([
            'user_id' => $weeklyPayment->user_id,
            'type' => 'income',
            'amount' => $weeklyPayment->amount,
            'description' => "Pembayaran Kas Mingguan - {$weeklyPayment->user->name} ({$this->getWeekPeriodDisplay($weeklyPayment->week_period)})",
            'source' => 'weekly_payment',
            'status' => 'approved',
            'approved_by' => auth()->user()->id,
            'approved_at' => now(),
            'notes' => $request->input('notes') ?: "Pembayaran kas mingguan"
        ]);

        // Update cash balance
        CashBalance::getCurrentBalance()->updateBalance();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dicatat! Kas bertambah Rp ' . number_format((float)$weeklyPayment->amount, 0, ',', '.')
            ]);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat! Kas bertambah Rp ' . number_format((float)$weeklyPayment->amount, 0, ',', '.'));
    }

    public function approvePayment(Request $request)
    {
        $this->authorize('manage_weekly_payments');

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $user = User::findOrFail($request->user_id);
        $amountPaid = $request->amount_paid;
        $weeklyAmount = 10000; // Default 10k per minggu
        $weeksToMark = floor($amountPaid / $weeklyAmount);

        if ($weeksToMark <= 0) {
            return redirect()->back()->with('error', 'Jumlah pembayaran tidak mencukupi untuk 1 minggu!');
        }

        // Get unpaid weekly payments for this user
        $unpaidPayments = WeeklyPayment::where('user_id', $request->user_id)
            ->where('is_paid', false)
            ->orderBy('week_period')
            ->limit($weeksToMark)
            ->get();

        if ($unpaidPayments->count() < $weeksToMark) {
            return redirect()->back()->with('error', 'Tidak ada cukup tagihan yang belum dibayar!');
        }

        // Mark payments as paid
        foreach ($unpaidPayments as $payment) {
            $payment->update([
                'is_paid' => true,
                'paid_at' => now(),
                'notes' => $request->input('notes') ?: "Pembayaran Rp " . number_format($amountPaid, 0, ',', '.')
            ]);
        }

        // Create transaction record for the payment
        Transaction::create([
            'user_id' => $request->user_id,
            'type' => 'income',
            'amount' => $amountPaid,
            'description' => "Pembayaran Kas Mingguan - {$user->name} ({$weeksToMark} minggu)",
            'source' => 'weekly_payment',
            'status' => 'approved',
            'approved_by' => auth()->user()->id,
            'approved_at' => now(),
            'notes' => $request->input('notes') ?: "Pembayaran kas mingguan {$weeksToMark} minggu"
        ]);

        // Update cash balance
        CashBalance::getCurrentBalance()->updateBalance();

        $remainingAmount = $amountPaid - ($weeksToMark * $weeklyAmount);
        $message = "Berhasil menandai {$weeksToMark} minggu sebagai lunas untuk {$user->name}! Pembayaran Rp " . number_format($amountPaid, 0, ',', '.') . " telah masuk ke total kas.";

        if ($remainingAmount > 0) {
            $message .= " Sisa pembayaran: Rp " . number_format($remainingAmount, 0, ',', '.');
        }

        return redirect()->back()->with('success', $message);
    }

    public function bulkApprove(Request $request)
    {
        $this->authorize('manage_weekly_payments');

        $request->validate([
            'week_period' => 'required|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $approvedCount = 0;

        foreach ($request->user_ids as $userId) {
            $weeklyPayment = WeeklyPayment::where('week_period', $request->week_period)
                ->where('user_id', $userId)
                ->first();

            if ($weeklyPayment && !$weeklyPayment->is_paid) {
                $weeklyPayment->update([
                    'is_paid' => true,
                    'paid_at' => now(),
                    'notes' => 'Bulk approval - ' . now()->format('d/m/Y H:i')
                ]);
                $approvedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil menyetujui {$approvedCount} pembayaran!");
    }

    public function markAsUnpaid(Request $request, WeeklyPayment $weeklyPayment)
    {
        try {
            $this->authorize('manage_weekly_payments');

            // Cari transaksi income yang terkait dengan pembayaran ini
            $relatedTransaction = Transaction::where('user_id', $weeklyPayment->user_id)
                ->where('type', 'income')
                ->where('source', 'weekly_payment')
                ->where('description', 'like', '%' . $weeklyPayment->user->name . '%')
                ->where('description', 'like', '%' . $this->getWeekPeriodDisplay($weeklyPayment->week_period) . '%')
                ->first();

            if ($relatedTransaction) {
                // Hapus transaksi income yang terkait
                $relatedTransaction->delete();
            }

            $weeklyPayment->update([
                'is_paid' => false,
                'paid_at' => null,
                'notes' => null
            ]);

            // Update cash balance
            CashBalance::getCurrentBalance()->updateBalance();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pembayaran berhasil diubah! Kas berkurang Rp ' . number_format((float)$weeklyPayment->amount, 0, ',', '.')
                ]);
            }

            return redirect()->back()->with('success', 'Status pembayaran berhasil diubah! Kas berkurang Rp ' . number_format((float)$weeklyPayment->amount, 0, ',', '.'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getCurrentWeekPeriod(): string
    {
        $now = now();
        $weekOfMonth = ceil($now->day / 7);
        return $now->format('Y-m') . '-W' . $weekOfMonth;
    }

    private function getAvailablePeriods(): array
    {
        $periods = WeeklyPayment::distinct()->pluck('week_period')->toArray();

        // Add current month periods if not exists
        $currentMonth = now()->format('Y-m');
        for ($week = 1; $week <= 4; $week++) {
            $period = $currentMonth . '-W' . $week;
            if (!in_array($period, $periods)) {
                $periods[] = $period;
            }
        }

        // Add previous months
        for ($i = 1; $i <= 6; $i++) {
            $month = now()->subMonths($i)->format('Y-m');
            for ($week = 1; $week <= 4; $week++) {
                $period = $month . '-W' . $week;
                if (!in_array($period, $periods)) {
                    $periods[] = $period;
                }
            }
        }

        rsort($periods);
        return $periods;
    }

    private function getAvailableMonths(): array
    {
        $months = [];

        // Add current month and previous months
        for ($i = 0; $i <= 12; $i++) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthName = now()->subMonths($i)->format('F Y');
            $months[$month] = $monthName;
        }

        return $months;
    }

    private function getAvailableMonthsForYear($year): array
    {
        $months = [];

        // Add all months for the specified year
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = $year . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $monthName = date('F', mktime(0, 0, 0, $i, 1, $year)) . ' ' . $year;
            $months[$monthValue] = $monthName;
        }

        return $months;
    }

    private function getAvailableYears(): array
    {
        $years = [];
        $currentYear = now()->year;

        // Add current year and next 5 years to cover more years
        for ($i = 0; $i < 6; $i++) {
            $year = $currentYear + $i;
            $years[$year] = $year;
        }

        return $years;
    }


    private function getMonthDisplay($monthValue): string
    {
        $parts = explode('-', $monthValue);
        if (count($parts) >= 2) {
            $year = $parts[0];
            $month = $parts[1];

            $monthNames = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ];

            return $monthNames[$month] . ' ' . $year;
        }

        return $monthValue;
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('manage_weekly_payments');

        // Apply same filters as index method
        $selectedYear = $request->get('year', now()->format('Y'));
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $selectedWeek = $request->get('week');
        $selectedUser = $request->get('user_id');

        $query = WeeklyPayment::with('user');

        // Filter by year, month and week
        if ($selectedYear) {
            if ($selectedMonth) {
                if ($selectedWeek) {
                    $query->where('week_period', $selectedMonth . '-W' . $selectedWeek);
                } else {
                    $query->where('week_period', 'like', $selectedMonth . '%');
                }
            } else {
                $query->where('week_period', 'like', $selectedYear . '%');
            }
        } else {
            // If no year selected, filter by month if specified
            if ($selectedMonth) {
                if ($selectedWeek) {
                    $query->where('week_period', $selectedMonth . '-W' . $selectedWeek);
                } else {
                    $query->where('week_period', 'like', $selectedMonth . '%');
                }
            }
        }

        // Filter by user if specified
        if ($selectedUser) {
            $query->where('user_id', $selectedUser);
        }

        $weeklyPayments = $query->orderBy('week_period')->orderBy('user_id')->get();

        // Create export with filtered data
        $export = new WeeklyPaymentsExport();
        $export->setData($weeklyPayments);

        $filename = 'weekly_payments_' . date('Y-m-d_H-i-s');

        // Add filter info to filename
        if ($selectedYear) {
            $filename .= '_' . $selectedYear;
        }
        if ($selectedMonth) {
            $filename .= '_' . str_replace('-', '', $selectedMonth);
        }
        if ($selectedWeek) {
            $filename .= '_week' . $selectedWeek;
        }
        if ($selectedUser) {
            $user = User::find($selectedUser);
            $filename .= '_' . str_replace(' ', '', $user->name ?? 'user' . $selectedUser);
        }

        return Excel::download($export, $filename . '.xlsx');
    }
}
