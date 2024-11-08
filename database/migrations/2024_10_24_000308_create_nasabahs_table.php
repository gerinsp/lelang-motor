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
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_motor')->unique()->constrained(
                table: 'motor'
            );
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_hp');
            $table->unsignedBigInteger('utang');
            $table->boolean('hapus_buku')->default(false);
            $table->boolean('kredit_lunas')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
