<?php

namespace App\Http\Controllers;

use App\Services\NovaPoshtaService;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected $novaPoshtaService;

    public function __construct(NovaPoshtaService $novaPoshtaService)
    {
        $this->novaPoshtaService = $novaPoshtaService;
    }

    /**
     * Get cities for delivery service
     */
    public function getCities(Request $request)
    {
        $service = $request->get('service', 'nova_poshta');

        try {
            if ($service === 'nova_poshta') {
                $cities = $this->novaPoshtaService->getCities();
            } else {
                // For ukrposhta - implement later
                $cities = collect();
            }

            return response()->json([
                'success' => true,
                'cities' => $cities,
                'service' => $service
            ]);
        } catch (\Exception $e) {
            \Log::error('Delivery API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading cities: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get warehouses/offices for specific city
     */
    public function getWarehouses(Request $request)
    {
        $request->validate([
            'service' => 'required|in:nova_poshta,ukrposhta',
            'city_ref' => 'required|string',
        ]);

        $service = $request->service;
        $cityRef = $request->city_ref;
        $query = $request->get('q'); // search query

        if ($service === 'nova_poshta') {
            $warehouses = $this->novaPoshtaService->getWarehouses($cityRef);

            if ($query) {
                $warehouses = collect($warehouses)->filter(function ($warehouse) use ($query) {
                    $address = data_get($warehouse, 'address', '');
                    $number = data_get($warehouse, 'number', '');
                    $fullAddress = data_get($warehouse, 'full_address', $address);

                    return str_contains(mb_strtolower($address), mb_strtolower($query))
                        || str_contains(mb_strtolower($number), mb_strtolower($query))
                        || str_contains(mb_strtolower($fullAddress), mb_strtolower($query));
                })->values();
            }
        } else {
            // For ukrposhta - implement later
            $warehouses = collect();
        }

        return response()->json([
            'success' => true,
            'warehouses' => collect($warehouses)->map(function ($warehouse) {
                return [
                    'ref' => data_get($warehouse, 'ref', null),
                    'number' => data_get($warehouse, 'number', ''),
                    'address' => data_get($warehouse, 'address', ''),
                    'full_address' => data_get($warehouse, 'full_address', data_get($warehouse, 'address', '')),
                ];
            })
        ]);
    }

    /**
     * Sync warehouses from API to database
     */
    public function syncWarehouses(Request $request)
    {
        try {
            $this->novaPoshtaService->syncWarehouses();

            return response()->json([
                'success' => true,
                'message' => 'Warehouses synchronized successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync warehouses: ' . $e->getMessage()
            ], 500);
        }
    }
}
