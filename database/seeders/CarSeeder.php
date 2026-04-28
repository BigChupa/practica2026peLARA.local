<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            ['make' => 'Toyota', 'model' => 'Camry', 'year' => '2015', 'trim' => 'LE'],
            ['make' => 'Toyota', 'model' => 'Camry', 'year' => '2018', 'trim' => 'LE'],
            ['make' => 'Toyota', 'model' => 'Camry', 'year' => '2020', 'trim' => 'SE'],
            ['make' => 'Toyota', 'model' => 'Corolla', 'year' => '2016', 'trim' => 'CE'],
            ['make' => 'Toyota', 'model' => 'Corolla', 'year' => '2019', 'trim' => 'SE'],
            ['make' => 'Toyota', 'model' => 'Corolla', 'year' => '2021', 'trim' => 'LE'],
            ['make' => 'Toyota', 'model' => 'RAV4', 'year' => '2015', 'trim' => 'LE'],
            ['make' => 'Toyota', 'model' => 'RAV4', 'year' => '2018', 'trim' => 'XLE'],
            ['make' => 'Toyota', 'model' => 'RAV4', 'year' => '2021', 'trim' => 'LE'],
            ['make' => 'Toyota', 'model' => 'Highlander', 'year' => '2017', 'trim' => 'LE'],
            ['make' => 'Toyota', 'model' => 'Highlander', 'year' => '2020', 'trim' => 'XLE'],
            ['make' => 'Toyota', 'model' => 'Tacoma', 'year' => '2016', 'trim' => 'SR'],
            ['make' => 'Toyota', 'model' => 'Tacoma', 'year' => '2019', 'trim' => 'SR5'],
            ['make' => 'Toyota', 'model' => '4Runner', 'year' => '2015', 'trim' => 'SR5'],
            ['make' => 'Toyota', 'model' => 'Prius', 'year' => '2018', 'trim' => 'LE'],
            
            ['make' => 'Honda', 'model' => 'Accord', 'year' => '2014', 'trim' => 'LX'],
            ['make' => 'Honda', 'model' => 'Accord', 'year' => '2017', 'trim' => 'EX'],
            ['make' => 'Honda', 'model' => 'Accord', 'year' => '2020', 'trim' => 'SE'],
            ['make' => 'Honda', 'model' => 'Civic', 'year' => '2015', 'trim' => 'LX'],
            ['make' => 'Honda', 'model' => 'Civic', 'year' => '2018', 'trim' => 'EX'],
            ['make' => 'Honda', 'model' => 'Civic', 'year' => '2021', 'trim' => 'EX'],
            ['make' => 'Honda', 'model' => 'CR-V', 'year' => '2015', 'trim' => 'LX'],
            ['make' => 'Honda', 'model' => 'CR-V', 'year' => '2018', 'trim' => 'EX'],
            ['make' => 'Honda', 'model' => 'CR-V', 'year' => '2021', 'trim' => 'LE'],
            ['make' => 'Honda', 'model' => 'Pilot', 'year' => '2016', 'trim' => 'EX'],
            ['make' => 'Honda', 'model' => 'Pilot', 'year' => '2019', 'trim' => 'EX-L'],
            ['make' => 'Honda', 'model' => 'Odyssey', 'year' => '2017', 'trim' => 'SE'],
            ['make' => 'Honda', 'model' => 'Odyssey', 'year' => '2020', 'trim' => 'EX'],
            
            ['make' => 'BMW', 'model' => '3 Series', 'year' => '2016', 'trim' => '320i'],
            ['make' => 'BMW', 'model' => '3 Series', 'year' => '2019', 'trim' => '330i'],
            ['make' => 'BMW', 'model' => '3 Series', 'year' => '2021', 'trim' => 'M340i'],
            ['make' => 'BMW', 'model' => '5 Series', 'year' => '2015', 'trim' => '528i'],
            ['make' => 'BMW', 'model' => '5 Series', 'year' => '2018', 'trim' => '540i'],
            ['make' => 'BMW', 'model' => 'X3', 'year' => '2016', 'trim' => 'xDrive28i'],
            ['make' => 'BMW', 'model' => 'X3', 'year' => '2019', 'trim' => 'xDrive30i'],
            ['make' => 'BMW', 'model' => 'X5', 'year' => '2015', 'trim' => 'xDrive35i'],
            ['make' => 'BMW', 'model' => 'X5', 'year' => '2018', 'trim' => 'xDrive40i'],
            ['make' => 'BMW', 'model' => 'X5', 'year' => '2021', 'trim' => 'xDrive40i'],
            
            ['make' => 'Mercedes-Benz', 'model' => 'C-Class', 'year' => '2015', 'trim' => 'C300'],
            ['make' => 'Mercedes-Benz', 'model' => 'C-Class', 'year' => '2018', 'trim' => 'C300'],
            ['make' => 'Mercedes-Benz', 'model' => 'E-Class', 'year' => '2016', 'trim' => 'E350'],
            ['make' => 'Mercedes-Benz', 'model' => 'E-Class', 'year' => '2019', 'trim' => 'E450'],
            ['make' => 'Mercedes-Benz', 'model' => 'GLE', 'year' => '2015', 'trim' => 'GLE350'],
            ['make' => 'Mercedes-Benz', 'model' => 'GLE', 'year' => '2018', 'trim' => 'GLE450'],
  
            ['make' => 'Ford', 'model' => 'F-150', 'year' => '2015', 'trim' => 'Regular Cab'],
            ['make' => 'Ford', 'model' => 'F-150', 'year' => '2018', 'trim' => 'SuperCrew'],
            ['make' => 'Ford', 'model' => 'F-150', 'year' => '2021', 'trim' => 'Crew Cab'],
            ['make' => 'Ford', 'model' => 'Mustang', 'year' => '2015', 'trim' => 'EcoBoost'],
            ['make' => 'Ford', 'model' => 'Mustang', 'year' => '2018', 'trim' => 'GT'],
            ['make' => 'Ford', 'model' => 'Mustang', 'year' => '2021', 'trim' => 'EcoBoost'],
            ['make' => 'Ford', 'model' => 'Explorer', 'year' => '2015', 'trim' => 'Base'],
            ['make' => 'Ford', 'model' => 'Explorer', 'year' => '2018', 'trim' => 'XLT'],
            ['make' => 'Ford', 'model' => 'Edge', 'year' => '2016', 'trim' => 'SE'],
            ['make' => 'Ford', 'model' => 'Focus', 'year' => '2015', 'trim' => 'SE'],
            
            ['make' => 'Chevrolet', 'model' => 'Silverado 1500', 'year' => '2015', 'trim' => 'Regular Cab'],
            ['make' => 'Chevrolet', 'model' => 'Silverado 1500', 'year' => '2018', 'trim' => 'Crew Cab'],
            ['make' => 'Chevrolet', 'model' => 'Silverado 1500', 'year' => '2021', 'trim' => 'LT'],
            ['make' => 'Chevrolet', 'model' => 'Corvette', 'year' => '2014', 'trim' => 'Base'],
            ['make' => 'Chevrolet', 'model' => 'Corvette', 'year' => '2020', 'trim' => 'Stingray'],
            ['make' => 'Chevrolet', 'model' => 'Equinox', 'year' => '2016', 'trim' => 'LT'],
            ['make' => 'Chevrolet', 'model' => 'Equinox', 'year' => '2019', 'trim' => 'LT'],
            ['make' => 'Chevrolet', 'model' => 'Malibu', 'year' => '2015', 'trim' => 'LS'],
            ['make' => 'Chevrolet', 'model' => 'Traverse', 'year' => '2015', 'trim' => 'LS'],
            
            ['make' => 'Tesla', 'model' => 'Model 3', 'year' => '2018', 'trim' => 'Standard Range'],
            ['make' => 'Tesla', 'model' => 'Model 3', 'year' => '2020', 'trim' => 'Standard Range Plus'],
            ['make' => 'Tesla', 'model' => 'Model S', 'year' => '2015', 'trim' => 'P90D'],
            ['make' => 'Tesla', 'model' => 'Model S', 'year' => '2018', 'trim' => 'Long Range'],
            ['make' => 'Tesla', 'model' => 'Model X', 'year' => '2016', 'trim' => 'P100D'],
            ['make' => 'Tesla', 'model' => 'Model X', 'year' => '2019', 'trim' => 'Long Range'],
            ['make' => 'Tesla', 'model' => 'Model Y', 'year' => '2020', 'trim' => 'Long Range'],
            
            ['make' => 'Volkswagen', 'model' => 'Jetta', 'year' => '2015', 'trim' => 'SE'],
            ['make' => 'Volkswagen', 'model' => 'Jetta', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Volkswagen', 'model' => 'Passat', 'year' => '2015', 'trim' => 'SE'],
            ['make' => 'Volkswagen', 'model' => 'Passat', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Volkswagen', 'model' => 'Golf', 'year' => '2015', 'trim' => 'S'],
            ['make' => 'Volkswagen', 'model' => 'Golf', 'year' => '2018', 'trim' => 'SE'],
            ['make' => 'Volkswagen', 'model' => 'Tiguan', 'year' => '2016', 'trim' => 'S'],
            
            ['make' => 'Hyundai', 'model' => 'Elantra', 'year' => '2015', 'trim' => 'SE'],
            ['make' => 'Hyundai', 'model' => 'Elantra', 'year' => '2018', 'trim' => 'SE'],
            ['make' => 'Hyundai', 'model' => 'Sonata', 'year' => '2015', 'trim' => 'SE'],
            ['make' => 'Hyundai', 'model' => 'Sonata', 'year' => '2018', 'trim' => 'SE'],
            ['make' => 'Hyundai', 'model' => 'Santa Fe', 'year' => '2015', 'trim' => 'SE'],
            ['make' => 'Hyundai', 'model' => 'Santa Fe', 'year' => '2018', 'trim' => 'SE'],
            
            ['make' => 'Kia', 'model' => 'Forte', 'year' => '2015', 'trim' => 'EX'],
            ['make' => 'Kia', 'model' => 'Forte', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Kia', 'model' => 'Optima', 'year' => '2015', 'trim' => 'LX'],
            ['make' => 'Kia', 'model' => 'Optima', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Kia', 'model' => 'Sportage', 'year' => '2016', 'trim' => 'LX'],
            ['make' => 'Kia', 'model' => 'Sportage', 'year' => '2019', 'trim' => 'LX'],
            ['make' => 'Kia', 'model' => 'Sorento', 'year' => '2015', 'trim' => 'LX'],
            
            ['make' => 'Mazda', 'model' => 'Mazda3', 'year' => '2015', 'trim' => 'i Sport'],
            ['make' => 'Mazda', 'model' => 'Mazda3', 'year' => '2018', 'trim' => 'i Sport'],
            ['make' => 'Mazda', 'model' => 'Mazda6', 'year' => '2015', 'trim' => 'i Sport'],
            ['make' => 'Mazda', 'model' => 'Mazda6', 'year' => '2018', 'trim' => 'i Touring'],
            ['make' => 'Mazda', 'model' => 'CX-5', 'year' => '2015', 'trim' => 'Sport'],
            ['make' => 'Mazda', 'model' => 'CX-5', 'year' => '2018', 'trim' => 'Touring'],
            
            ['make' => 'Nissan', 'model' => 'Altima', 'year' => '2015', 'trim' => '2.5S'],
            ['make' => 'Nissan', 'model' => 'Altima', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Nissan', 'model' => 'Sentra', 'year' => '2015', 'trim' => 'S'],
            ['make' => 'Nissan', 'model' => 'Sentra', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Nissan', 'model' => 'Rogue', 'year' => '2015', 'trim' => 'S'],
            ['make' => 'Nissan', 'model' => 'Rogue', 'year' => '2018', 'trim' => 'S'],
            ['make' => 'Nissan', 'model' => 'Pathfinder', 'year' => '2014', 'trim' => 'S'],
            
            ['make' => 'Audi', 'model' => 'A4', 'year' => '2015', 'trim' => 'Ultra'],
            ['make' => 'Audi', 'model' => 'A4', 'year' => '2018', 'trim' => 'Premium'],
            ['make' => 'Audi', 'model' => 'A6', 'year' => '2015', 'trim' => 'Premium'],
            ['make' => 'Audi', 'model' => 'Q3', 'year' => '2015', 'trim' => 'Premium'],
            ['make' => 'Audi', 'model' => 'Q5', 'year' => '2015', 'trim' => 'Premium'],
            ['make' => 'Audi', 'model' => 'Q5', 'year' => '2018', 'trim' => 'Premium'],
            
            ['make' => 'Lexus', 'model' => 'ES 350', 'year' => '2015', 'trim' => 'Base'],
            ['make' => 'Lexus', 'model' => 'RX 350', 'year' => '2015', 'trim' => 'Base'],
            ['make' => 'Lexus', 'model' => 'RX 350', 'year' => '2018', 'trim' => 'F Sport'],
            ['make' => 'Lexus', 'model' => 'GX 460', 'year' => '2015', 'trim' => 'Base'],
            
            ['make' => 'Jeep', 'model' => 'Wrangler', 'year' => '2015', 'trim' => 'Sport'],
            ['make' => 'Jeep', 'model' => 'Wrangler', 'year' => '2018', 'trim' => 'Sport'],
            ['make' => 'Jeep', 'model' => 'Cherokee', 'year' => '2015', 'trim' => 'Sport'],
            ['make' => 'Jeep', 'model' => 'Cherokee', 'year' => '2018', 'trim' => 'Latitude'],
            ['make' => 'Jeep', 'model' => 'Grand Cherokee', 'year' => '2015', 'trim' => 'Laredo'],
            ['make' => 'Jeep', 'model' => 'Renegade', 'year' => '2015', 'trim' => 'Sport'],
            
            ['make' => 'Ram', 'model' => '1500', 'year' => '2015', 'trim' => 'Regular Cab'],
            ['make' => 'Ram', 'model' => '1500', 'year' => '2018', 'trim' => 'Crew Cab'],
            ['make' => 'Ram', 'model' => '2500', 'year' => '2015', 'trim' => 'Regular Cab'],
            
            ['make' => 'GMC', 'model' => 'Sierra 1500', 'year' => '2015', 'trim' => 'Regular Cab'],
            ['make' => 'GMC', 'model' => 'Sierra 1500', 'year' => '2018', 'trim' => 'Crew Cab'],
            ['make' => 'GMC', 'model' => 'Terrain', 'year' => '2015', 'trim' => 'SLE'],
            
            ['make' => 'Subaru', 'model' => 'Outback', 'year' => '2015', 'trim' => '2.5i'],
            ['make' => 'Subaru', 'model' => 'Outback', 'year' => '2018', 'trim' => '2.5i'],
            ['make' => 'Subaru', 'model' => 'Impreza', 'year' => '2015', 'trim' => '2.0i'],
            ['make' => 'Subaru', 'model' => 'Crosstrek', 'year' => '2015', 'trim' => '2.0i'],
            ['make' => 'Subaru', 'model' => 'Crosstrek', 'year' => '2018', 'trim' => '2.0i'],
            
            ['make' => 'Volvo', 'model' => 'S60', 'year' => '2015', 'trim' => 'T5 Momentum'],
            ['make' => 'Volvo', 'model' => 'V60', 'year' => '2015', 'trim' => 'T5 Momentum'],
            ['make' => 'Volvo', 'model' => 'XC90', 'year' => '2015', 'trim' => 'T5 Momentum'],
        ];

        foreach ($cars as $car) {
            Car::firstOrCreate(
                ['make' => $car['make'], 'model' => $car['model'], 'year' => $car['year']],
                $car
            );
        }
    }
}
