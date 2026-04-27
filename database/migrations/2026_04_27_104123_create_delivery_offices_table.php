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
        Schema::create('delivery_offices', function (Blueprint $table) {
            $table->id();
            $table->string('service')->index(); // nova_poshta, ukrposhta
            $table->string('ref')->index(); // API reference
            $table->string('number'); // office number
            $table->string('city_ref')->index(); // city API reference
            $table->string('city_name');
            $table->text('address');
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->json('schedule')->nullable(); // working hours
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['service', 'city_ref']);
            $table->index(['service', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_offices');
    }
};
