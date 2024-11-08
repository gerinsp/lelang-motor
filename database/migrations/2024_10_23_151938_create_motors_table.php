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
        Schema::create('motor', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('keterangan')->nullable();
            $table->year('tahun_pembuatan');
            $table->string('merk');
            $table->string('jenis');
            $table->integer('kapasitas_mesin');
            $table->string('bahan_bakar');
            $table->integer('odometer');
            $table->string('nomor_rangka');
            $table->string('nomor_mesin');
            $table->string('nomor_polisi');
            $table->string('warna');
            $table->boolean('stnk');
            $table->date('masa_berlaku_stnk');
            $table->boolean('bpkb');
            $table->boolean('faktur');
            $table->boolean('foto_kopi_ktp');
            $table->boolean('kwitansi_blanko');
            $table->boolean('form_a');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor');
    }
};
