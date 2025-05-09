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
        Schema::create('pengesahan', function (Blueprint $table) {
            $table->uuid('id_pengesahan')->primary();

            $table->string('catatan_pengesahan');
            $table->string('status_pengesahan');
            $table->dateTime('waktu_pengesahan');


            $table->foreignUuid('id_verifikasi')
                ->references('id_verifikasi')
                ->on('verifikasi')
                ->onDelete('cascade');

            $table->foreignUuid('id_wd_dua')
                ->references('id_wd_dua')
                ->on('wadek')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengesahan');
    }
};
