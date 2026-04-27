<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Убрать уникальное ограничение с vin если колонка существует
            if (Schema::hasColumn('cars', 'vin')) {
                // Попробуем удалить индекс если он существует
                try {
                    $table->dropUnique(['vin']);
                } catch (\Exception $e) {
                    // Индекс может не существовать, это нормально
                }
                
                $table->dropColumn('vin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('vin')->nullable()->unique();
        });
    }
};
