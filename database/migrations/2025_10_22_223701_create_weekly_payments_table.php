<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weekly_payments', function (Blueprint $table) {
            $table->id();
            $table->string('week_period'); // Format: "2024-10-W1" (tahun-bulan-minggu)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(0); // Jumlah yang harus dibayar
            $table->boolean('is_paid')->default(false); // Status pembayaran
            $table->timestamp('paid_at')->nullable(); // Tanggal pembayaran
            $table->text('notes')->nullable(); // Catatan
            $table->timestamps();

            $table->unique(['week_period', 'user_id']); // Satu user hanya bisa punya satu record per minggu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_payments');
    }
};
