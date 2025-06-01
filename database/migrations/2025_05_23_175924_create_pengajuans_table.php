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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();
            $table->string('nama')->index(); // Name of the activity
            $table->enum('tingkat', ['BNSP', 'Nasional', 'Internasional'])->nullable()->index();
            $table->string('lokasi');
            $table->enum('kategori', ['Pemohonan', 'Reimburse']);
            $table->date('periodeMulai')->nullable();
            $table->date('periodeSelesai')->nullable();
            $table->text('deskripsi');
            $table->enum('status', ['diproses_admin', 'verifikasi_ku', 'verifikasi_wd', 'pengesahan', 'disetujui', 'ditolak'])
                ->default('diproses_admin')->index();
            $table->text('catatan')->nullable();
            $table->string('proposal')->nullable(); // Path to proposal file
            $table->string('bukti')->nullable();   // Path to bukti file
            $table->decimal('anggaran', 10, 2)->nullable()->comment('Budget in IDR, updated by Kepala Unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
