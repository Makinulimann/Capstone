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
        Schema::create('pengajuan_sertifikasi', function (Blueprint $table) {
            $table->uuid('id_pengajuan')->primary();

            $table->string('nama_sertifikasi');
            $table->string('jenis_sertifikasi');
            $table->string('sumber_pendanaan');
            $table->string('lokasi_sertifikasi');
            $table->date('tanggal_sertifikasi');
            $table->string('penyelenggara_sertifikasi');
            $table->string('file_sertifikat')->nullable();
            $table->string('status_pengajuan_sertifikasi');
            $table->dateTime('waktu_pengajuan_sertifikasi');

            $table->foreignUuid('id_dosen')
                ->references('id_dosen')
                ->on('dosen_filkom')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sertifikasi');
    }
};
