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
        Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->integer('rating')->nullable()->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
