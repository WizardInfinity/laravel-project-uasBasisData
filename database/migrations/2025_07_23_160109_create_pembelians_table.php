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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->time('jam_tayang'); // Jam tayang yang dipilih (09:00, 13:00, 19:00)
            $table->json('kursi_dipilih'); // Menyimpan array kursi yang dipilih (A1, A2, B3, dll)
            $table->decimal('total', 10, 2); // Total harga pembelian
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['user_id', 'created_at']);
            $table->index(['movie_id', 'jam_tayang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};