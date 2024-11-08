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
        Schema::create('penawaran_lelang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lelang')->constrained(
                table: 'lelang'
            );
            $table->foreignId('id_user')->constrained(
                table: 'users'
            );
            $table->unsignedBigInteger('penawaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran_lelang');
    }
};
