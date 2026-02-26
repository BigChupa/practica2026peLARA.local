<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Зробити user_id nullable
            if (Schema::hasColumn('appointments', 'user_id')) {
                $table->foreignId('user_id')->nullable()->change();
            }
            
            // Зробити appointment_date nullable
            if (Schema::hasColumn('appointments', 'appointment_date')) {
                $table->dateTime('appointment_date')->nullable()->change();
            }
            
            // Додати name та phone для гостей
            if (!Schema::hasColumn('appointments', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'phone')) {
                $table->string('phone')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('appointments', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
