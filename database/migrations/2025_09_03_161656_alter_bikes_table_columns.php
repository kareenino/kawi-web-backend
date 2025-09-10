<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->renameColumn('model', 'name');
            $table->dropColumn(['year', 'odometer_km', 'photo_url']);
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->renameColumn('name', 'model');

            $table->unsignedSmallInteger('year')->nullable()->after('model');
            $table->unsignedInteger('odometer_km')->nullable()->after('last_serviced_at');
            $table->string('photo_url')->nullable()->after('odometer_km');

            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};