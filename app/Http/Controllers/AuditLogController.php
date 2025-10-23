<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('view_audit_logs');

        $query = AuditLog::with(['user']);

        // Filter berdasarkan action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter berdasarkan model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->latest()->paginate(20);

        // Data untuk filter
        $actions = ['CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT', 'APPROVE', 'REJECT'];
        $modelTypes = [
            'App\\Models\\User' => 'User',
            'App\\Models\\Transaction' => 'Transaksi',
            'App\\Models\\PaymentProof' => 'Bukti Pembayaran',
            'App\\Models\\WeeklyPayment' => 'Pembayaran Mingguan',
            'App\\Models\\CashBalance' => 'Saldo Kas'
        ];
        $users = User::select('id', 'name')->get();

        return view('audit-logs.index', compact('auditLogs', 'actions', 'modelTypes', 'users'));
    }

    public function show(AuditLog $auditLog)
    {
        $this->authorize('view_audit_logs');

        return view('audit-logs.show', compact('auditLog'));
    }

    public static function log($action, $model = null, $oldValues = null, $newValues = null, $description = null)
    {
        $auditLog = new AuditLog();
        $auditLog->action = $action;
        $auditLog->user_id = Auth::id();
        $auditLog->ip_address = request()->ip();
        $auditLog->user_agent = request()->userAgent();
        $auditLog->description = $description;

        if ($model) {
            $auditLog->model_type = get_class($model);
            $auditLog->model_id = $model->id;
        }

        if ($oldValues) {
            $auditLog->old_values = $oldValues;
        }

        if ($newValues) {
            $auditLog->new_values = $newValues;
        }

        $auditLog->save();
    }
}
