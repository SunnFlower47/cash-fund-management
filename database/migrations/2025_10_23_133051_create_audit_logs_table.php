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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // CREATE, UPDATE, DELETE, LOGIN, LOGOUT, etc
            $table->string('model_type')->nullable(); // Model yang diubah
            $table->unsignedBigInteger('model_id')->nullable(); // ID model yang diubah
            $table->unsignedBigInteger('user_id'); // User yang melakukan aksi
            $table->json('old_values')->nullable(); // Nilai lama
            $table->json('new_values')->nullable(); // Nilai baru
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('description')->nullable(); // Deskripsi aksi
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['action', 'model_type', 'model_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
