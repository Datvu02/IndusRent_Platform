<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    private const ROUTE_MAP = [
        'cho-thue-nha-xuong' => [
            'slug' => 'nha-xuong-cho-thue',
            'title_key' => 'common.listing_warehouse_rent',
            'seo_title' => 'Cho thuê nhà xưởng | Rich Hưng Thịnh',
            'seo_description' => 'Tìm kiếm nhà xưởng cho thuê phù hợp nhu cầu sản xuất, kinh doanh tại Rich Hưng Thịnh. Thông tin diện tích, vị trí và giá thuê.',
            'seo_heading' => 'Cho thuê nhà xưởng',
        ],
        'cho-thue-kho' => [
            'slug' => 'kho-cho-thue',
            'title_key' => 'common.listing_warehouse',
            'seo_title' => 'Cho thuê kho | Rich Hưng Thịnh',
            'seo_description' => 'Tìm kiếm kho cho thuê phù hợp nhu cầu lưu trữ và kinh doanh. Xem thông tin diện tích, vị trí và giá thuê tại Rich Hưng Thịnh.',
            'seo_heading' => 'Cho thuê kho',
        ],
        'cho-thue-mat-bang' => [
             'slug' => 'mat-bang-cho-thue',
             'title_key' => 'common.listing_premises',
             'seo_title' => 'Cho thuê mặt bằng | Rich Hưng Thịnh',
             'seo_description' => 'Tìm kiếm mặt bằng cho thuê phù hợp nhu cầu kinh doanh và sản xuất. Xem thông tin vị trí, diện tích và giá thuê tại Rich Hưng Thịnh.',
             'seo_heading' => 'Cho thuê mặt bằng',
        ],
        'dat-ban' => [
             'slug' => 'dat-ban',
             'title_key' => 'common.listing_land_sale',
             'seo_title' => 'Đất bán | Rich Hưng Thịnh',
             'seo_description' => 'Tìm kiếm thông tin đất bán với nhiều lựa chọn về vị trí, diện tích và giá. Khám phá các tin đăng đất bán tại Rich Hưng Thịnh.',
             'seo_heading' => 'Đất bán',
        ],
        'nha-xuong-ban' => [
             'slug' => 'nha-xuong-ban',
             'title_key' => 'common.listing_warehouse_sale',
             'seo_title' => 'Nhà xưởng bán | Rich Hưng Thịnh',
             'seo_description' => 'Tìm kiếm nhà xưởng bán phù hợp nhu cầu sản xuất và đầu tư. Xem thông tin vị trí, diện tích và giá tại Rich Hưng Thịnh.',
             'seo_heading' => 'Nhà xưởng bán',
        ],
    ];

    public function show(string $listingSlug, Request $request): View
    {
        $config = self::ROUTE_MAP[$listingSlug] ?? null;
        if (! $config) {
            abort(404);
        }

        $type = PropertyType::where('slug', $config['slug'])->first();
        $listingUrl = url('/' . $listingSlug);

        if (! $type) {
	    return view('frontend.pages.listing', [
	        'listingTitle' => __($config['title_key']),
	        'listingUrl' => $listingUrl,
	        'seoTitle' => $config['seo_title'],
	        'seoDescription' => $config['seo_description'],
		'seoHeading' => $config['seo_heading'],
	        'items' => [],
                'pagination' => null,
	    ]);
        }

        $query = Property::with('location')
            ->where('type_id', $type->id)
            ->where('is_published', true)
            ->orderByDesc('updated_at');

        $properties = $query->paginate(10);

        $items = $properties->getCollection()->map(function (Property $p) use ($listingSlug) {
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
        });

	return view('frontend.pages.listing', [
	    'listingTitle' => __($config['title_key']),
	    'listingUrl' => $listingUrl,
	    'seoTitle' => $config['seo_title'],
	    'seoDescription' => $config['seo_description'],
	    'seoHeading' => $config['seo_heading'],
	    'items' => $items,
	    'pagination' => $properties,
	]);
    }

    public function search(Request $request): View
    {
        $listingUrl = url('/tim-kiem');
        $query = Property::with('type', 'location')
            ->where('is_published', true)
            ->orderByDesc('updated_at');

        if ($request->filled('skey')) {
            $q = $request->input('skey');
            $query->where(function ($qry) use ($q) {
                $qry->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%');
            });
        }
        if ($request->filled('mnu')) {
            $query->where('type_id', $request->input('mnu'));
        }
        if ($request->filled('city')) {
            $query->where('location_id', $request->input('city'));
        }
        if ($request->filled('price')) {
            $parts = explode('^', (string) $request->input('price'));
            if (count($parts) === 2) {
                if ((float) $parts[0] > 0) {
                    $query->where('price', '>=', (float) $parts[0]);
                }
                if ((float) $parts[1] > 0) {
                    $query->where('price', '<=', (float) $parts[1]);
                }
            }
        }

        $properties = $query->paginate(10)->withQueryString();

        $items = $properties->getCollection()->map(function (Property $p) {
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
        });

        return view('frontend.pages.listing', [
            'listingTitle' => __('common.search_results'),
            'listingUrl' => $listingUrl,
            'items' => $items,
            'pagination' => $properties,
        ]);
    }

    public function propertyDetail(string $slug): View
    {
        $property = Property::where('slug', $slug)
            ->where('is_published', true)
            ->with('type', 'location')
            ->firstOrFail();

        $seoTitle = $property->title_translated . ' | Rich Hưng Thịnh';

        $description = strip_tags((string) ($property->description_translated ?? $property->description));

        $seoDescription = \Illuminate\Support\Str::limit(
            trim($description),
            155,
            '...'
        );

        if ($seoDescription === '') {
            $location = $property->location?->location_line;
            $type = $property->type?->name_translated ?? 'bất động sản';

            $seoDescription = trim(
                $type .
                ($property->area ? ' diện tích ' . number_format($property->area) . ' m²' : '') .
                ($location ? ' tại ' . $location : '') .
                ' | Rich Hưng Thịnh.'
            );
        }

        return view('frontend.pages.property-detail', compact(
            'property',
            'seoTitle',
            'seoDescription'
        ));
    }
}
