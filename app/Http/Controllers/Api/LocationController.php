<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getProvinces()
    {
        $provinces = Location::select("province", "province_en", "province_zh")
            ->distinct()
            ->orderBy("province")
            ->get()
            ->map(function($item) {
                return [
                    "value" => $item->province,
                    "label" => $item->province,
                    "label_en" => $item->province_en,
                    "label_zh" => $item->province_zh,
                ];
            });
        
        return response()->json($provinces);
    }

    public function getDistricts(Request $request)
    {
        $province = $request->get("province");
        
        if (!$province) {
            return response()->json([]);
        }
        
        $districts = Location::where("province", $province)
            ->select("district", "district_en", "district_zh")
            ->distinct()
            ->orderBy("district")
            ->get()
            ->map(function($item) {
                return [
                    "value" => $item->district,
                    "label" => $item->district,
                    "label_en" => $item->district_en,
                    "label_zh" => $item->district_zh,
                ];
            });
        
        return response()->json($districts);
    }

    public function getWards(Request $request)
    {
        $province = $request->get("province");
        $district = $request->get("district");
        
        if (!$province || !$district) {
            return response()->json([]);
        }
        
        $wards = Location::where("province", $province)
            ->where("district", $district)
            ->whereNotNull("ward")
            ->select("id", "ward", "ward_en", "ward_zh")
            ->orderBy("ward")
            ->get()
            ->map(function($item) {
                return [
                    "value" => $item->id,
                    "label" => $item->ward,
                    "label_en" => $item->ward_en,
                    "label_zh" => $item->ward_zh,
                ];
            });
        
        return response()->json($wards);
    }
}
