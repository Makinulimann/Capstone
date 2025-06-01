<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedAtToPengajuanStatusHistory extends Migration
{
    public function up()
    {
        Schema::table('pengajuan_status_history', function (Blueprint $table) {
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::table('pengajuan_status_history', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
}
