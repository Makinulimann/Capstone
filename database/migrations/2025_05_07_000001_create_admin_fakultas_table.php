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
        Schema::create('admin_fakultas', function (Blueprint $table) {
            $table->uuid('id_admin')->primary();
            $table->string('email_admin')->unique();
            $table->string('nama_admin');

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
        Schema::dropIfExists('admin_fakultas');
    }
};
