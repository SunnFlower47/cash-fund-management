<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class CleanupMemberPaymentTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete transactions with source 'member_payment' as they are not needed
        // Cash is handled in the Kas Mingguan menu, not through payment proofs
        $deletedCount = Transaction::where('source', 'member_payment')->delete();

        $this->command->info("Deleted {$deletedCount} member payment transactions that are no longer needed.");
        $this->command->info("Payment proofs now only handle file uploads and approval status.");
        $this->command->info("Cash transactions are handled separately in the Kas Mingguan menu.");
    }
}
