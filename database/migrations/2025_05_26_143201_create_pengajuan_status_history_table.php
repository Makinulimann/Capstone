<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the table if it exists to avoid conflicts
        Schema::dropIfExists('pengajuan_status_history');

        Schema::create('pengajuan_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')
                ->constrained('pengajuans', 'id')
                ->onDelete('cascade')
                ->cascadeOnUpdate()
                ->comment('Foreign key to pengajuans table')
                ->name('fk_pengajuan_status_history_pengajuan_id');
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->onDelete('cascade')
                ->cascadeOnUpdate()
                ->comment('Foreign key to users table')
                ->name('fk_pengajuan_status_history_user_id');
            $table->enum('role', ['admin', 'kepala_unit', 'wakil_dekan'])->index();
            $table->enum('status', ['diproses_admin', 'verifikasi_ku', 'pengesahan', 'disetujui', 'ditolak']);
            $table->text('catatan')->nullable();
            $table->decimal('anggaran', 10, 2)->nullable()->comment('Updated budget if changed');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_status_history');
    }
};