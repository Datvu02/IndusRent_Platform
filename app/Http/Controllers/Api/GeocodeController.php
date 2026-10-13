<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeocodeController extends Controller
{
    private const NOMINATIM_BASE = 'https://nominatim.openstreetmap.org';
    private const USER_AGENT = 'IndusRentPlatform/1.0 (property map picker; contact@indusrent.local)';

    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));
        if (mb_strlen($q) < 3) {
            return response()->json([]);
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => self::USER_AGENT,
                'Accept-Language' => 'vi,en',
            ])
                ->timeout(8)
                ->get(self::NOMINATIM_BASE . '/search', [
                    'format' => 'json',
                    'limit' => 7,
                    'countrycodes' => 'vn',
                    'q' => $q,
                ]);

            if (!$response->successful()) {
                return response()->json(['error' => 'geocode_failed'], 502);
            }

            return response()->json($response->json() ?? []);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'geocode_unavailable'], 502);
        }
    }

    public function reverse(Request $request): JsonResponse
    {
        $lat = $request->query('lat');
        $lon = $request->query('lon');

        if (!is_numeric($lat) || !is_numeric($lon)) {
            return response()->json(['error' => 'invalid_coords'], 422);
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => self::USER_AGENT,
                'Accept-Language' => 'vi,en',
            ])
                ->timeout(8)
                ->get(self::NOMINATIM_BASE . '/reverse', [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lon,
                ]);

            if (!$response->successful()) {
                return response()->json(['error' => 'geocode_failed'], 502);
            }

            return response()->json($response->json() ?? []);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'geocode_unavailable'], 502);
        }
    }
}
