<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nidn', 15)->unique()->check("'nidn' REGEXP '^[0-9]{15}$'")->comment('15-digit NIDN');
            $table->string('email')->unique()->index();
            $table->string('photo')->nullable(); // Path to photo
            $table->string('department')->nullable()
                ->check("department IN ('Teknik Informatika', 'Sistem Informasi') OR department IS NULL")
                ->comment('Derived from first 2 digits of NIDN: 11=TI, 12=SI');
            $table->enum('role', ['dosen', 'admin', 'kepala_unit', 'wakil_dekan'])->default('dosen')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
