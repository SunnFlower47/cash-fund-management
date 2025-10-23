<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'action',
        'model_type',
        'model_id',
        'user_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'description'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function getActionDisplayAttribute(): string
    {
        return match($this->action) {
            'CREATE' => 'Membuat',
            'UPDATE' => 'Mengubah',
            'DELETE' => 'Menghapus',
            'LOGIN' => 'Login',
            'LOGOUT' => 'Logout',
            'APPROVE' => 'Menyetujui',
            'REJECT' => 'Menolak',
            default => $this->action
        };
    }

    public function getModelDisplayAttribute(): string
    {
        return match($this->model_type) {
            'App\\Models\\User' => 'User',
            'App\\Models\\Transaction' => 'Transaksi',
            'App\\Models\\PaymentProof' => 'Bukti Pembayaran',
            'App\\Models\\WeeklyPayment' => 'Pembayaran Mingguan',
            'App\\Models\\CashBalance' => 'Saldo Kas',
            default => $this->model_type
        };
    }
}
