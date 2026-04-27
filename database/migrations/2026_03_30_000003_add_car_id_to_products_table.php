<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'car_id')) {
                $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('set null')->after('compatible_vins');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'car_id')) {
                $table->dropForeign(['car_id']);
                $table->dropColumn('car_id');
            }
        });
    }
};
