<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 dark:border-slate-700">
                <div class="p-4 text-gray-900 dark:text-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center space-x-3">
                                <img src="{{ asset('receipt.png') }}" alt="Receipt" class="w-8 h-8 object-contain">
                                <span>Daftar Bukti Pembayaran</span>
                            </h1>
                            <p class="text-gray-600 dark:text-slate-400 mt-1">Kelola bukti pembayaran transaksi</p>
                        </div>
                        @can('create_payment_proofs')
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('payment-proofs.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white font-medium rounded-lg hover:from-green-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                <img src="{{ asset('receipt.png') }}" alt="Upload Payment Proof" class="w-4 h-4 mr-2 object-contain">
                                Upload Bukti Pembayaran
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm overflow-hidden shadow-lg rounded-2xl border border-slate-200/60 dark:border-slate-700/60">
                <div class="p-4 text-slate-900 dark:text-slate-100">
                    @if($paymentProofs->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama File</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Ukuran</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                    @foreach($paymentProofs as $proof)
                                    <tr class="hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 dark:hover:from-slate-700 dark:hover:to-slate-600 transition-all duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center">
                                                    <img src="{{ asset('profile.png') }}" alt="Nama" class="w-8 h-8 object-contain">
                                                </div>
                                                <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $proof->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center">
                                                    <img src="{{ asset('receipt.png') }}" alt="File" class="w-8 h-8 object-contain">
                                                </div>
                                                <a href="{{ $proof->file_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium hover:underline truncate max-w-xs">
                                                {{ Str::limit($proof->file_name, 25, '...') }}
                                            </a>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                            {{ $proof->formatted_file_size }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $proof->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($proof->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                                {{ $proof->status === 'approved' ? 'Disetujui' : ($proof->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                            {{ $proof->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 dark:text-slate-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('payment-proofs.show', $proof) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">Lihat</a>

                                                @if(auth()->user()->isBendahara() && $proof->status === 'pending')
                                                <button onclick="openApproveModal({{ $proof->id }})" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 text-sm font-medium hover:underline">Setujui</button>
                                                <button onclick="openRejectModal({{ $proof->id }})" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Tolak</button>
                                                @endif

                                                <a href="{{ route('payment-proofs.edit', $proof) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 text-sm font-medium hover:underline">Edit</a>

                                                @can('delete_payment_proofs')
                                                @if($proof->user_id === auth()->id())
                                                <button onclick="deletePaymentProof('{{ $proof->id }}', 'desktop')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Hapus</button>
                                                <form id="delete-proof-desktop-{{ $proof->id }}" method="POST" action="{{ route('payment-proofs.destroy', $proof) }}" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach($paymentProofs as $proof)
                            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 p-3 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('receipt.png') }}" alt="File" class="w-8 h-8 object-contain">
                                        </div>
                                        <div>
                                            <a href="{{ $proof->file_url }}" target="_blank" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                                {{ Str::limit($proof->file_name, 14, '...') }}
                                            </a>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $proof->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500">by {{ $proof->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $proof->formatted_file_size }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $proof->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700' : ($proof->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-rose-100 dark:bg-rose-900/50 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-700') }}">
                                        {{ $proof->status === 'approved' ? 'Disetujui' : ($proof->status === 'pending' ? 'Pending' : 'Ditolak') }}
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('payment-proofs.show', $proof) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium hover:underline">Lihat</a>
                                    @if(auth()->user()->isBendahara() && $proof->status === 'pending')
                                    <button onclick="openApproveModal({{ $proof->id }})" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 text-sm font-medium hover:underline">Setujui</button>
                                    <button onclick="openRejectModal({{ $proof->id }})" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">Tolak</button>
                                    @endif
                                    <a href="{{ route('payment-proofs.edit', $proof) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 text-sm font-medium hover:underline">Edit</a>
                                    @can('delete_payment_proofs')
                                    @if($proof->user_id === auth()->id() || auth()->user()->isBendahara())
                                    <button onclick="deletePaymentProof('{{ $proof->id }}', 'mobile')" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-medium hover:underline">
                                        Hapus
                                    </button>
                                    <form id="delete-proof-mobile-{{ $proof->id }}" method="POST" action="{{ route('payment-proofs.destroy', $proof) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif

                                    @endcan
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $paymentProofs->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="flex items-center justify-center mx-auto mb-6">
                                <img src="{{ asset('receipt.png') }}" alt="No Payment Proofs" class="w-20 h-20 object-contain">
                            </div>
                            <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-300 mb-2">Belum ada bukti pembayaran</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-6">Mulai dengan mengupload bukti pembayaran pertama</p>
                            @can('create_payment_proofs')
                            <a href="{{ route('payment-proofs.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-green-400 to-blue-400 hover:from-green-500 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                                <img src="{{ asset('receipt.png') }}" alt="Upload First Payment Proof" class="w-5 h-5 object-contain">
                                <span>Upload Bukti Pembayaran Pertama</span>
                            </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    @if(auth()->user()->isBendahara())
    <div id="approveModal" class="fixed inset-0 bg-slate-600/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-4 border w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-sm">
            <div class="mt-3">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('present.png') }}" alt="Approve" class="w-8 h-8 object-contain">
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Setujui Bukti Pembayaran</h3>
                </div>
                <form id="approveForm" method="POST">
                    @csrf
                    <div class="mb-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('seting.png') }}" alt="Warning" class="w-5 h-5 object-contain">
                                <span class="text-sm font-medium text-yellow-800">Peringatan</span>
                            </div>
                            <p class="text-sm text-yellow-700 mt-2">Ini hanya mengubah status bukti pembayaran. Untuk menambah kas, gunakan menu Kas Mingguan.</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-bold text-slate-700 mb-3">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-slate-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition-all duration-200" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeApproveModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-6 rounded-2xl transition-all duration-200 border border-slate-200 hover:border-slate-300">
                            Batal
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-emerald-400 to-green-400 hover:from-emerald-500 hover:to-green-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                            Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-slate-600/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-4 border w-96 shadow-2xl rounded-2xl bg-white/95 backdrop-blur-sm">
            <div class="mt-3">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('discount.png') }}" alt="Reject" class="w-8 h-8 object-contain">
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Tolak Bukti Pembayaran</h3>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="review_notes" class="block text-sm font-bold text-slate-700 mb-3">Alasan Penolakan</label>
                        <textarea id="review_notes" name="review_notes" rows="3" class="mt-1 block w-full border-slate-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition-all duration-200" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-6 rounded-2xl transition-all duration-200 border border-slate-200 hover:border-slate-300">
                            Batal
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-rose-400 to-red-400 hover:from-rose-500 hover:to-red-500 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @endif
    <script>
        function openApproveModal(proofId) {
            document.getElementById('approveForm').action = `/payment-proofs/${proofId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal(proofId) {
            document.getElementById('rejectForm').action = `/payment-proofs/${proofId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function deletePaymentProof(proofId, type) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan bukti pembayaran yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-proof-' + type + '-' + proofId).submit();
                }
            });
        }
    </script>
</x-app-layout>
