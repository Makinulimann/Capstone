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
        Schema::create('dosen_filkom', function (Blueprint $table) {
            $table->uuid('id_dosen')->primary();
            $table->string('email_dosen')->unique();
            $table->string('nidn_dosen')->unique();
            $table->string('nama_dosen');
            $table->string('departemen_dosen');
            $table->string('prodi_dosen');
            $table->string('no_telp_dosen');

            $table->foreignUuid('id_role')
                ->references('id_role')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreignUuid('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_filkom');
    }
};
