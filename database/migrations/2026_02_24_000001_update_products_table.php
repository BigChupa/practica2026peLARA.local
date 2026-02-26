<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Замінити string 'category' на foreign key
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }
            
            // Додати category_id та image_path
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeignIdFor(\App\Models\Category::class);
                $table->dropColumn('category_id');
            }
            
            if (Schema::hasColumn('products', 'image_path')) {
                $table->dropColumn('image_path');
            }
            
            $table->string('category');
        });
    }
};
