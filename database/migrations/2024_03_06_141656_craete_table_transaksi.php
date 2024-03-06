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
        Schema::create('transaksi_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->references('id')->on('users');
            $table->string('perihal');
            $table->string('surat_jalan');
            $table->date('tanggal');
            $table->enum('status', ['pengajuan', 'diterima', 'ditolak']);
            $table->foreignId('approver_id')->references('id')->on('users')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
