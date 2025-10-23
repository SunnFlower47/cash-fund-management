<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\PaymentProof;
use App\Models\CashBalance;
use App\Models\WeeklyPayment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cashBalance = CashBalance::getCurrentBalance();

        if ($user->isBendahara()) {
            // Bendahara dashboard
            $pendingTransactions = Transaction::where('status', 'pending')->count();
            $pendingProofs = PaymentProof::where('status', 'pending')->count();
            $recentTransactions = Transaction::with(['user'])
                ->latest()
                ->limit(10)
                ->get();

            $allPaymentProofs = PaymentProof::with(['user', 'transactions'])
                ->latest()
                ->limit(10)
                ->get();

            return view('dashboard.bendahara', compact(
                'cashBalance',
                'pendingTransactions',
                'pendingProofs',
                'recentTransactions',
                'allPaymentProofs'
            ));
        } else {
            // Anggota dashboard - show weekly payment transactions
            $userTransactions = Transaction::where('user_id', $user->id)
                ->latest()
                ->get();

            $userPaymentProofs = PaymentProof::where('user_id', $user->id)
                ->latest()
                ->get();

            // Get weekly payments for current month
            $currentMonth = now()->format('Y-m');
            $weeklyPayments = WeeklyPayment::where('user_id', $user->id)
                ->where('week_period', 'like', $currentMonth . '%')
                ->orderBy('week_period')
                ->get();

            return view('dashboard.anggota', compact(
                'cashBalance',
                'userTransactions',
                'userPaymentProofs',
                'weeklyPayments'
            ));
        }
    }
}
