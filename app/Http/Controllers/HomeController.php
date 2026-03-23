<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\News;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public static function propertiesToItems(Collection $properties): array
    {
        return $properties->map(function (Property $p) {
            $locationName = $p->location
                ? $p->location->location_line
                : '—';
            $areaStr = $p->area ? number_format($p->area) . ' m²' : '—';
            $desc = $p->description_translated ?? $p->description;
            return [
                'title' => $p->title_translated,
                'url' => url('/tin-dang/' . $p->slug),
                'price' => $p->formatted_price,
                'unit' => '',
                'area' => $areaStr,
                'location' => $locationName,
                'desc' => \Illuminate\Support\Str::limit(strip_tags((string) $desc), 120),
                'image' => $p->main_image ? asset('storage/' . $p->main_image) : null,
            ];
        })->all();
    }

    public function index(): View
    {
        $propertyTypes = PropertyType::orderBy('name')->get();
        $locations = Location::orderBy('province')->orderBy('district')->get();

        $typeWarehouseRent = PropertyType::where('slug', 'nha-xuong-cho-thue')->first();
        $typeLandSale = PropertyType::where('slug', 'dat-ban')->first();
        $typePremises = PropertyType::where('slug', 'mat-bang-cho-thue')->first();
        $typeWarehouseSale = PropertyType::where('slug', 'nha-xuong-ban')->first();

        $baseQuery = fn () => Property::with('location')->where('is_published', true)->orderByDesc('updated_at');

        $latestWarehouseRent = $typeWarehouseRent
            ? $baseQuery()->where('type_id', $typeWarehouseRent->id)->limit(4)->get()
            : collect();
        $latestLandSale = $typeLandSale
            ? $baseQuery()->where('type_id', $typeLandSale->id)->limit(3)->get()
            : collect();
        $latestPremises = $typePremises
            ? $baseQuery()->where('type_id', $typePremises->id)->limit(2)->get()
            : collect();

        $rentTypeIds = PropertyType::whereIn('slug', ['nha-xuong-cho-thue', 'kho-cho-thue', 'mat-bang-cho-thue'])->pluck('id');
        $transferTypeIds = PropertyType::whereIn('slug', ['dat-ban', 'nha-xuong-ban'])->pluck('id');

        $topRent = $rentTypeIds->isNotEmpty()
            ? $baseQuery()->whereIn('type_id', $rentTypeIds)->limit(3)->get()
            : collect();
        $topTransfer = $transferTypeIds->isNotEmpty()
            ? $baseQuery()->whereIn('type_id', $transferTypeIds)->limit(3)->get()
            : collect();

        $latestNews = News::orderByDesc('updated_at')->limit(2)->get();
        $sliders = Slider::active()->ordered()->get();

        return view('frontend.home', [
            'propertyTypes' => $propertyTypes,
            'locations' => $locations,
            'sliders' => $sliders,
            'latestWarehouseRent' => self::propertiesToItems($latestWarehouseRent),
            'latestLandSale' => self::propertiesToItems($latestLandSale),
            'latestPremises' => self::propertiesToItems($latestPremises),
            'topRent' => self::propertiesToItems($topRent),
            'topTransfer' => self::propertiesToItems($topTransfer),
            'latestNews' => $latestNews,
        ]);
    }
}
