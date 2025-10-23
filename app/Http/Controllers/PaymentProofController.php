<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentProof;
use App\Models\Transaction;
use App\Models\CashBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentProofController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isBendahara()) {
            $paymentProofs = PaymentProof::with(['user', 'reviewer'])
                ->latest()
                ->paginate(20);
        } else {
            $paymentProofs = PaymentProof::where('user_id', $user->id)
                ->with(['reviewer'])
                ->latest()
                ->paginate(20);
        }

        return view('payment-proofs.index', compact('paymentProofs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create_payment_proofs');

        return view('payment-proofs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create_payment_proofs');

        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB max
            'member_name' => 'required|string|in:Ridwan,Ilham,Nabas,Burman,Ganda,Karlos'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('payment-proofs', $fileName, 'public');

        $paymentProof = PaymentProof::create([
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'status' => 'pending'
        ]);

        // Note: Tidak membuat transaksi di sini karena kas dihandle di menu Kas Mingguan

        return redirect()->route('payment-proofs.index')
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentProof $paymentProof)
    {
        $this->authorize('view_payment_proofs');

        // Check if user can view this payment proof
        if (!Auth::user()->isBendahara() && $paymentProof->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payment-proofs.show', compact('paymentProof'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentProof $paymentProof)
    {
        $this->authorize('edit_payment_proofs');

        // Check if user can edit this payment proof
        if (!Auth::user()->isBendahara() && $paymentProof->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payment-proofs.edit', compact('paymentProof'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentProof $paymentProof)
    {
        $this->authorize('edit_payment_proofs');

        // Check if user can edit this payment proof
        if (!Auth::user()->isBendahara() && $paymentProof->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($paymentProof->file_path);

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('payment-proofs', $fileName, 'public');

            $paymentProof->update([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('payment-proofs.index')
            ->with('success', 'Bukti pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentProof $paymentProof)
    {
        $this->authorize('delete_payment_proofs');

        // Check if user can delete this payment proof
        if (!Auth::user()->isBendahara() && $paymentProof->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete file
        Storage::disk('public')->delete($paymentProof->file_path);

        $paymentProof->delete();

        return redirect()->route('payment-proofs.index')
            ->with('success', 'Bukti pembayaran berhasil dihapus.');
    }

    /**
     * Approve a payment proof
     */
    public function approve(Request $request, PaymentProof $paymentProof)
    {
        $this->authorize('approve_payment_proofs');

        $paymentProof->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->notes ?? 'Bukti pembayaran disetujui'
        ]);

        // Note: Kas tidak ditambah di sini karena sudah dihandle di menu Kas Mingguan
        // Function ini hanya untuk mengubah status bukti pembayaran

        return redirect()->back()
            ->with('success', 'Bukti pembayaran berhasil disetujui. Untuk menambah kas, gunakan menu Kas Mingguan.');
    }

    /**
     * Reject a payment proof
     */
    public function reject(Request $request, PaymentProof $paymentProof)
    {
        $this->authorize('reject_payment_proofs');

        $request->validate([
            'review_notes' => 'required|string'
        ]);

        $paymentProof->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->review_notes
        ]);

        // Update related transaction
        $transaction = Transaction::where('payment_proof_id', $paymentProof->id)->first();
        if ($transaction) {
            $transaction->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'notes' => $request->review_notes
            ]);
        }

        return redirect()->back()
            ->with('success', 'Bukti pembayaran berhasil ditolak.');
    }
}
