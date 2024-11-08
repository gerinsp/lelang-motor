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
        Schema::create('lelang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_motor')->constrained(
                table: 'motor'
            );
            $table->string('keterangan')->nullable();
            $table->enum('status_lelang', ['akan datang', 'berlangsung', 'selesai'])->default('akan datang');
            $table->dateTime('waktu_mulai_lelang');
            $table->dateTime('waktu_selesai_lelang')->nullable();
            $table->unsignedBigInteger('harga_awal');
            $table->unsignedBigInteger('uang_jaminan')->nullable();
            $table->foreignId('id_pemenang')->nullable()->constrained(
                table: 'users'
            );
            $table->unsignedBigInteger('penawaran_akhir')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['pending', 'validated', 'rejected'])->default('pending');
            $table->foreignId('id_validator')->nullable()->constrained(
                table: 'users'
            );
            $table->dateTime('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelang');
    }
};
