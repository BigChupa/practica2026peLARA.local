<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected function productJsonPath(): string
    {
        $paths = [
            base_path('database/data/bez_zagolovka.json'),
            'C:\\Users\\User\\Desktop\\Без заголовка.json',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        throw new RuntimeException('Product JSON file not found. Place it at database/data/bez_zagolovka.json or on your desktop as Без заголовка.json.');
    }

    protected function parseJsonDate(?string $value): string
    {
        if (empty($value)) {
            return now()->toDateTimeString();
        }

        $formats = [
            'j/n/Y H:i:s',
            'd/m/Y H:i:s',
            'Y-m-d H:i:s',
        ];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date !== false) {
                return $date->format('Y-m-d H:i:s');
            }
        }

        return now()->toDateTimeString();
    }

    public function up(): void
    {
        $path = $this->productJsonPath();
        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException("Unable to read product JSON file: {$path}");
        }

        $products = json_decode($content, true);
        if (!is_array($products)) {
            throw new RuntimeException("Invalid product JSON data in: {$path}");
        }

        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();

        foreach ($products as $product) {
            if (empty($product['sku'])) continue; 

            DB::table('products')->updateOrInsert(
        ['sku' => $product['sku']],
        [
            'id' => $product['id'] ?? null,
            'name' => $product['name'] ?? '',
            'description' => $product['description'] ?? null,
            'price' => $product['price'] ?? 0,
            'stock_quantity' => $product['stock_quantity'] ?? 0,
            'category_id' => $product['category_id'] ?? null,
            'compatible_make' => $product['compatible_make'] ?? null,
            'compatible_model' => $product['compatible_model'] ?? null,
            'compatible_year' => $product['compatible_year'] ?? null,
            'compatible_vins' => is_array($product['compatible_vins'] ?? null)
                ? json_encode($product['compatible_vins'])
                : $product['compatible_vins'] ?? null,
            'image_path' => $product['image_path'] ?? null,
            'car_id' => $product['car_id'] ?? null,
            'created_at' => $this->parseJsonDate($product['created_at'] ?? null),
            'updated_at' => $this->parseJsonDate($product['updated_at'] ?? null),
        ]
    );
}

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();
    }
};
