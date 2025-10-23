<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashBalance extends Model
{
    protected $fillable = [
        'total_income',
        'total_expense',
        'current_balance',
        'approved_income',
        'manual_income',
        'member_payments',
        'last_updated_at'
    ];

    protected $casts = [
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'approved_income' => 'decimal:2',
        'manual_income' => 'decimal:2',
        'member_payments' => 'decimal:2',
        'last_updated_at' => 'datetime',
    ];

    public static function getCurrentBalance()
    {
        $balance = self::first();

        if (!$balance) {
            $balance = self::create([
                'total_income' => 0,
                'total_expense' => 0,
                'current_balance' => 0,
                'approved_income' => 0,
                'manual_income' => 0,
                'member_payments' => 0,
                'last_updated_at' => now(),
            ]);
        }

        return $balance;
    }

    public function updateBalance()
    {
        // Calculate from transactions
        $approvedIncome = Transaction::where('type', 'income')
            ->where('status', 'approved')
            ->sum('amount');

        $totalExpense = Transaction::where('type', 'expense')
            ->where('status', 'approved')
            ->sum('amount');

        $memberPayments = Transaction::where('type', 'income')
            ->where('source', 'member_payment')
            ->where('status', 'approved')
            ->sum('amount');

        $manualIncome = Transaction::where('type', 'income')
            ->where('source', 'manual_income')
            ->where('status', 'approved')
            ->sum('amount');

        $currentBalance = $approvedIncome - $totalExpense;

        $this->update([
            'total_income' => $approvedIncome,
            'total_expense' => $totalExpense,
            'current_balance' => $currentBalance,
            'approved_income' => $approvedIncome,
            'manual_income' => $manualIncome,
            'member_payments' => $memberPayments,
            'last_updated_at' => now(),
        ]);

        return $this;
    }

    public function getBalanceSummary()
    {
        return [
            'current_balance' => $this->current_balance,
            'total_income' => $this->total_income,
            'total_expense' => $this->total_expense,
            'approved_income' => $this->approved_income,
            'manual_income' => $this->manual_income,
            'member_payments' => $this->member_payments,
            'last_updated' => $this->last_updated_at,
        ];
    }
}
