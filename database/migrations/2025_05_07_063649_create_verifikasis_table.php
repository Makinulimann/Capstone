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
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->uuid('id_verifikasi')->primary();
            $table->string('catatan_verifikasi');
            $table->string('status_verifikasi');
            $table->dateTime('waktu_verifikasi');


            $table->foreignUuid('id_pengajuan')
                ->references('id_pengajuan')
                ->on('pengajuan_sertifikasi')
                ->onDelete('cascade');

            $table->foreignUuid('id_admin')
                ->references('id_admin')
                ->on('admin_fakultas')
                ->onDelete('cascade');

            $table->foreignUuid('id_ketua_unit')
                ->references('id_ketua_unit')
                ->on('ketua_unit')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi');
    }
};
