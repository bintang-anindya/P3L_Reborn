<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('diskusi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_diskusi_induk')->nullable()->after('id_diskusi');
            $table->foreign('id_diskusi_induk')->references('id_diskusi')->on('diskusi')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diskusi', function (Blueprint $table) {
            //
        });
    }
};
