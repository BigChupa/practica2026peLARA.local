<?php

namespace Database\Seeders;

use App\Models\DeliveryOffice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            // Київ
            [
                'service' => 'nova_poshta',
                'ref' => 'kyiv-1',
                'number' => '1',
                'city_ref' => 'kyiv-ref',
                'city_name' => 'Київ',
                'address' => 'вул. Хрещатик, 1',
                'longitude' => 30.5238,
                'latitude' => 50.4501,
            ],
            [
                'service' => 'nova_poshta',
                'ref' => 'kyiv-2',
                'number' => '2',
                'city_ref' => 'kyiv-ref',
                'city_name' => 'Київ',
                'address' => 'вул. Володимирська, 45',
                'longitude' => 30.5167,
                'latitude' => 50.4489,
            ],
            [
                'service' => 'nova_poshta',
                'ref' => 'kyiv-3',
                'number' => '3',
                'city_ref' => 'kyiv-ref',
                'city_name' => 'Київ',
                'address' => 'пр. Перемоги, 100',
                'longitude' => 30.4981,
                'latitude' => 50.4547,
            ],

            // Львів
            [
                'service' => 'nova_poshta',
                'ref' => 'lviv-1',
                'number' => '1',
                'city_ref' => 'lviv-ref',
                'city_name' => 'Львів',
                'address' => 'пл. Ринок, 1',
                'longitude' => 24.0316,
                'latitude' => 49.8397,
            ],
            [
                'service' => 'nova_poshta',
                'ref' => 'lviv-2',
                'number' => '2',
                'city_ref' => 'lviv-ref',
                'city_name' => 'Львів',
                'address' => 'вул. Городоцька, 50',
                'longitude' => 24.0194,
                'latitude' => 49.8356,
            ],

            // Одеса
            [
                'service' => 'nova_poshta',
                'ref' => 'odesa-1',
                'number' => '1',
                'city_ref' => 'odesa-ref',
                'city_name' => 'Одеса',
                'address' => 'вул. Дерибасівська, 1',
                'longitude' => 30.7233,
                'latitude' => 46.4825,
            ],
            [
                'service' => 'nova_poshta',
                'ref' => 'odesa-2',
                'number' => '2',
                'city_ref' => 'odesa-ref',
                'city_name' => 'Одеса',
                'address' => 'пр. Шевченка, 25',
                'longitude' => 30.7326,
                'latitude' => 46.4775,
            ],

            // Харків
            [
                'service' => 'nova_poshta',
                'ref' => 'kharkiv-1',
                'number' => '1',
                'city_ref' => 'kharkiv-ref',
                'city_name' => 'Харків',
                'address' => 'пл. Свободи, 5',
                'longitude' => 36.2304,
                'latitude' => 49.9935,
            ],
            [
                'service' => 'nova_poshta',
                'ref' => 'kharkiv-2',
                'number' => '2',
                'city_ref' => 'kharkiv-ref',
                'city_name' => 'Харків',
                'address' => 'вул. Сумська, 100',
                'longitude' => 36.2314,
                'latitude' => 49.9925,
            ],
        ];

        foreach ($offices as $office) {
            DeliveryOffice::create($office);
        }
    }
}
