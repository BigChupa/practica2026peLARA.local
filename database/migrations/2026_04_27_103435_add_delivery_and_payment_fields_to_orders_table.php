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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_service', ['nova_poshta', 'ukrposhta'])->after('status');
            $table->enum('delivery_type', ['post_office', 'postomat', 'home_delivery'])->after('delivery_service');
            $table->string('delivery_city')->nullable()->after('delivery_type');
            $table->text('delivery_address')->nullable()->after('delivery_city');
            $table->enum('payment_method', ['bank_transfer'])->default('bank_transfer')->after('delivery_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_service', 'delivery_type', 'delivery_city', 'delivery_address', 'payment_method']);
        });
    }
};
