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
        Schema::create('reimbursement', function (Blueprint $table) {
            $table->uuid('id_reimbursement');

            $table->string('tipe_klaim');
            $table->decimal('total_klaim');
            $table->string('receipt_klaim');
            $table->string('status_klaim');
            $table->dateTime('waktu_klaim');


            $table->foreignUuid('id_pengajuan')
                ->references('id_pengajuan')
                ->on('pengajuan_sertifikasi')
                ->onDelete('cascade');

            $table->foreignUuid('id_pengesahan')
                ->references('id_pengesahan')
                ->on('pengesahan')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement');
    }
};
