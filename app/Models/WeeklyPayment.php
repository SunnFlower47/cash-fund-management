<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyPayment extends Model
{
    protected $fillable = [
        'week_period',
        'user_id',
        'amount',
        'is_paid',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getWeekPeriodDisplayAttribute(): string
    {
        $parts = explode('-', $this->week_period);
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

        return $this->week_period;
    }
}
