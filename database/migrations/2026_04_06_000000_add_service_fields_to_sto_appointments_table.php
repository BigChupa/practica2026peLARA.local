<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sto_appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable()->after('id');
            $table->string('service_name')->nullable()->after('service_id');

            $table->foreign('service_id')
                  ->references('id')
                  ->on('services')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sto_appointments', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn(['service_id', 'service_name']);
        });
    }
};
