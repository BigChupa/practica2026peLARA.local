<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'compatible_make')) {
                $table->string('compatible_make')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('products', 'compatible_model')) {
                $table->string('compatible_model')->nullable()->after('compatible_make');
            }
            if (!Schema::hasColumn('products', 'compatible_year')) {
                $table->string('compatible_year')->nullable()->after('compatible_model');
            }
            if (!Schema::hasColumn('products', 'compatible_vins')) {
                $table->text('compatible_vins')->nullable()->after('compatible_year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'compatible_vins')) {
                $table->dropColumn('compatible_vins');
            }
            if (Schema::hasColumn('products', 'compatible_year')) {
                $table->dropColumn('compatible_year');
            }
            if (Schema::hasColumn('products', 'compatible_model')) {
                $table->dropColumn('compatible_model');
            }
            if (Schema::hasColumn('products', 'compatible_make')) {
                $table->dropColumn('compatible_make');
            }
        });
    }
};
