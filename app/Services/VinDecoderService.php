<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VinDecoderService
{
    private const OPENDATABOT_API_URL = 'https://api.opendatabot.com/v1/vehicle';
    private $apiKey;

    public function __construct()
    {
        // Используйте env('OPENDATABOT_API_KEY') если есть, иначе используйте публичный API
        $this->apiKey = env('OPENDATABOT_API_KEY', '');
    }

    /**
     * Декодирует VIN код через Opendatabot API
     */
    public function decode(string $vin): array
    {
        $vin = strtoupper(trim($vin));
        
        if (strlen($vin) < 10) {
            throw new \Exception('VIN слишком короткий (мінімум 10 символів)');
        }

        try {
            // Спробируем использовать Opendatabot API
            $data = $this->decodeFromOpendatabot($vin);
            return $data;
        } catch (\Exception $e) {
            // Если API не работает, используем базовое декодирование
            return $this->decodeBasicInfo($vin);
        }
    }

    /**
     * Декодирует VIN через свободные API
     */
    private function decodeFromOpendatabot(string $vin): array
    {
        // Попытка 1: NHTSA API (работает для любых VIN)
        try {
            $response = Http::timeout(5)->get('https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/' . $vin, [
                'format' => 'json',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['Results']) && is_array($data['Results']) && count($data['Results']) > 0) {
                    $results = $data['Results'];
                    
                    // Ищем нужные поля в результатах NHTSA (они возвращаются как массив объектов)
                    $make = null;
                    $model = null;
                    $year = null;
                    
                    foreach ($results as $result) {
                        if (isset($result['Variable']) && isset($result['Value'])) {
                            if ($result['Variable'] === 'Make') {
                                $make = $result['Value'];
                            }
                            if ($result['Variable'] === 'Model') {
                                $model = $result['Value'];
                            }
                            if ($result['Variable'] === 'Model Year') {
                                $year = $result['Value'];
                            }
                        }
                    }
                    
                    if ($make && $model) {
                        return [
                            'success' => true,
                            'vin' => $vin,
                            'make' => $make,
                            'model' => $model,
                            'year' => $year ?: '',
                            'trim' => null,
                            'source' => 'nhtsa'
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            // Продолжим к следующему API
        }

        // Попытка 2: CarQueryAPI
        try {
            $response = Http::timeout(5)->get('https://carqueryapi.com/api/0.3/', [
                'cmd' => 'getModel',
                'vin' => $vin,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // CarQuery возвращает make_model_name как "Make Model"
                if (isset($data['model_name']) && !isset($data['error'])) {
                    $fullName = $data['make_model_name'] ?? '';
                    $parts = explode(' ', trim($fullName), 2);
                    
                    $make = $parts[0] ?? 'Unknown';
                    $model = $data['model_name'] ?? 'Unknown';
                    $year = $data['model_year'] ?? '';
                    
                    return [
                        'success' => true,
                        'vin' => $vin,
                        'make' => $make,
                        'model' => $model,
                        'year' => $year,
                        'trim' => $data['model_trim'] ?? null,
                        'source' => 'carqueryapi'
                    ];
                }
            }
        } catch (\Exception $e) {
            // Продолжим к следующему API
        }

        // Попытка 3: VINDecoder.pl
        try {
            $response = Http::timeout(5)->get('https://vindecoder.pl/api', [
                'vin' => $vin,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['results']) && is_array($data['results']) && count($data['results']) > 0) {
                    $result = $data['results'][0];
                    $make = $result['Make'] ?? 'Unknown';
                    $model = $result['Model'] ?? 'Unknown';
                    $year = $result['ModelYear'] ?? '';
                    
                    return [
                        'success' => true,
                        'vin' => $vin,
                        'make' => $make,
                        'model' => $model,
                        'year' => $year,
                        'trim' => $result['Trim'] ?? $result['Body'] ?? null,
                        'source' => 'vindecoder.pl'
                    ];
                }
            }
        } catch (\Exception $e) {
            // Если все платные API не сработали, используем базовый способ
        }

        throw new \Exception('VIN не найден в базе данных API');
    }

    /**
     * Альтернативный источник данных (CarQuery или другие)
     */
    private function decodeFromAlternativeSource(string $vin): array
    {
        try {
            $response = Http::timeout(5)->get('https://carqueryapi.com/api/0.3/', [
                'cmd' => 'getModel',
                'vin' => $vin,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (!isset($data['model_name'])) {
                    throw new \Exception('Модель не найдена');
                }

                // Попытаемся парсить make из make_model_name
                $fullName = $data['make_model_name'] ?? '';
                $parts = explode(' ', $fullName, 2);
                $make = $parts[0] ?? 'Unknown';
                $model = $data['model_name'] ?? 'Unknown';
                $year = $data['model_year'] ?? '';

                return [
                    'success' => true,
                    'vin' => $vin,
                    'make' => $make,
                    'model' => $model,
                    'year' => $year,
                    'trim' => $data['model_trim'] ?? null,
                    'source' => 'carqueryapi'
                ];
            }

            throw new \Exception('Альтернативный API не доступен');
        } catch (\Exception $e) {
            throw new \Exception('Помилка декодування VIN: ' . $e->getMessage());
        }
    }

    /**
     * Базовая информация из VIN кода (при отсутствии API)
     */
    private function decodeBasicInfo(string $vin): array
    {
        $manufacturerMap = $this->getManufacturerMap();
        
        $wmi = substr($vin, 0, 3);
        
        $manufacturer = 'Unknown';
        foreach ($manufacturerMap as $code => $name) {
            if (strpos($wmi, $code) === 0) {
                $manufacturer = $name;
                break;
            }
        }

        $yearChar = substr($vin, 9, 1);
        $year = $this->getYearFromChar($yearChar);

        return [
            'success' => true,
            'vin' => $vin,
            'make' => $manufacturer,
            'model' => 'Unknown',
            'year' => $year,
            'trim' => null,
            'source' => 'vin_basic',
            'note' => 'Часткова інформація з VIN коду (повні дані недоступні)'
        ];
    }

    /**
     * Карта производителей (WMI коды)
     */
    private function getManufacturerMap(): array
    {
        return [
            '1G' => 'Chevrolet/General Motors',
            '1GT' => 'GMC/General Motors',
            '2G1' => 'Pontiac/General Motors',
            'JT' => 'Toyota',
            'JH' => 'Honda',
            'KM' => 'Hyundai',
            'KMHEC4A' => 'Hyundai',
            'KNDJP' => 'Kia',
            'KNDMC' => 'Kia',
            'KNDPB' => 'Kia',
            'KNDHF' => 'Hyundai',
            'WAG' => 'Volkswagen',
            'WVW' => 'Volkswagen',
            'WDB' => 'Mercedes-Benz',
            'BMW' => 'BMW',
            'ZDM' => 'ZAZ',
            'VIN' => 'Lada/ВАЗ',
            'XTA' => 'Lada/ВАЗ',
            '3G5' => 'Cadillac',
            '5GR' => 'Rolls Royce',
        ];
    }

    /**
     * Конвертує код року в число
     */
    private function getYearFromChar(string $char): string
    {
        $yearMap = [
            'A' => '2010', 'B' => '2011', 'C' => '2012', 'D' => '2013', 'E' => '2014',
            'F' => '2015', 'G' => '2016', 'H' => '2017', 'J' => '2018', 'K' => '2019',
            'L' => '2020', 'M' => '2021', 'N' => '2022', 'P' => '2023', 'R' => '2024',
            'S' => '2025', 'T' => '2026', 'V' => '2027', 'W' => '2028', 'X' => '2029',
            'Y' => '2030', '1' => '2031', '2' => '2032', '3' => '2033', '4' => '2034',
            '5' => '2035', '6' => '2036', '7' => '2037', '8' => '2038', '9' => '2039',
        ];

        return $yearMap[$char] ?? '';
    }
}
