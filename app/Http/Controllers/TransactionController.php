<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\CashBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Start with base query - show all transactions (income and expense)
        $query = Transaction::with(['user', 'approver']);

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Get filtered transactions
        $transactions = $query->latest()->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create_transactions');

        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create_transactions');

        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'source' => $request->source ?? ($request->type === 'income' ? 'manual_income' : 'expense'),
            'status' => 'approved', // Bendahara can create approved transactions
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes
        ]);

        // Update cash balance
        CashBalance::getCurrentBalance()->updateBalance();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Check if user can view this transaction
        if (!Auth::user()->isBendahara() && $transaction->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat transaksi ini.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('edit_transactions');

        // Check if user can edit this transaction
        if (!Auth::user()->isBendahara() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('edit_transactions');

        // Check if user can edit this transaction
        if (!Auth::user()->isBendahara() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $transaction->update($request->all());

        // Update cash balance
        CashBalance::getCurrentBalance()->updateBalance();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete_transactions');

        // Check if user can delete this transaction
        if (!Auth::user()->isBendahara() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        // Update cash balance
        CashBalance::getCurrentBalance()->updateBalance();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Approve a transaction
     */
    public function approve(Transaction $transaction)
    {
        $this->authorize('approve_transactions');

        $transaction->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        // Update related payment proof if exists
        if ($transaction->payment_proof_id) {
            $paymentProof = \App\Models\PaymentProof::find($transaction->payment_proof_id);
            if ($paymentProof) {
                $paymentProof->update([
                    'status' => 'approved',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now()
                ]);
            }
        }

        // Update cash balance
        CashBalance::getCurrentBalance()->updateBalance();

        return redirect()->back()
            ->with('success', 'Transaksi berhasil disetujui.');
    }

    /**
     * Reject a transaction
     */
    public function reject(Request $request, Transaction $transaction)
    {
        $this->authorize('approve_transactions');

        $request->validate([
            'notes' => 'required|string'
        ]);

        $transaction->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $request->notes
        ]);

        // Update related payment proof if exists
        if ($transaction->payment_proof_id) {
            $paymentProof = \App\Models\PaymentProof::find($transaction->payment_proof_id);
            if ($paymentProof) {
                $paymentProof->update([
                    'status' => 'rejected',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                    'review_notes' => $request->notes
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Transaksi berhasil ditolak.');
    }
}
