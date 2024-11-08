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
        Schema::create('transaksi_saldo_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained(
                table: 'users'
            );
            $table->string('keterangan')->nullable();
            $table->enum('arus_transaksi', ['pemasukan', 'pengeluaran']);
            $table->unsignedInteger('nominal');
            $table->string('bukti_transaksi');
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
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
        Schema::dropIfExists('transaksi_saldo_user');
    }
};
