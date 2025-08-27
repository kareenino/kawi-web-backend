<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('mpesa_phone', 20)->nullable()->after('amount');
            $table->string('merchant_request_id')->nullable()->after('mpesa_phone');
            $table->string('checkout_request_id')->nullable()->after('merchant_request_id');
            $table->string('mpesa_receipt')->nullable()->after('checkout_request_id');
            $table->string('result_code')->nullable()->after('mpesa_receipt');
            $table->string('result_desc')->nullable()->after('result_code');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'mpesa_phone',
                'merchant_request_id',
                'checkout_request_id',
                'mpesa_receipt',
                'result_code',
                'result_desc',
            ]);
        });
    }
};