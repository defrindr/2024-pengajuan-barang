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
        Schema::create('transaksi_masuk_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_masuk_id')->references('id')->on('transaksi_masuk');
            $table->foreignId('item_id')->references('id')->on('inventaris')->default(null);
            $table->string('nama_barang');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
