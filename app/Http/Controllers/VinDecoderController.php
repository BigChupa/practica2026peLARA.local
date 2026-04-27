<?php

namespace App\Http\Controllers;

use App\Services\VinDecoderService;
use Illuminate\Http\Request;

class VinDecoderController extends Controller
{
    protected $vinDecoder;

    public function __construct(VinDecoderService $vinDecoder)
    {
        $this->vinDecoder = $vinDecoder;
    }

    public function decode(Request $request)
    {
        $request->validate(['vin' => 'required|string|min:10|max:20']);
        
        $vin = trim($request->input('vin'));
        
        try {
            $carData = $this->vinDecoder->decode($vin);
            return response()->json($carData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
