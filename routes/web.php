<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EditorImageController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Models\News;
use App\Models\Property;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', function (string $locale) {
    $allowed = ['vi', 'en', 'zh'];
    if (! in_array($locale, $allowed, true)) {
        return redirect()->back();
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('locale.switch')->where('locale', 'vi|en|zh');

Route::get('/test-location', function () {
    return view('test-location');
});

Route::get('/sitemap.xml', function () {
    $staticPages = [
        '/',
        '/gioi-thieu',
        '/lien-he',
        '/noi-dung-yeu-cau',
        '/dich-vu',
        '/tin-tuc',
        '/cho-thue-nha-xuong',
        '/cho-thue-kho',
        '/cho-thue-mat-bang',
        '/dat-ban',
        '/nha-xuong-ban',
        '/danh-sach-quan-tam',
    ];

    $urls = [];

    foreach ($staticPages as $path) {
        $urls[] = [
            'loc' => url($path),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => $path === '/' ? '1.0' : '0.8',
        ];
    }

    $properties = Property::query()
        ->where('is_published', true)
        ->select('slug', 'updated_at')
        ->orderByDesc('updated_at')
        ->get();

    foreach ($properties as $property) {
        $urls[] = [
            'loc' => url('/tin-dang/' . $property->slug),
            'lastmod' => optional($property->updated_at)->toAtomString() ?? now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
    }

    $newsItems = News::query()
        ->select('slug', 'updated_at')
        ->orderByDesc('updated_at')
        ->get();

    foreach ($newsItems as $item) {
        $urls[] = [
            'loc' => url('/tin-tuc/' . $item->slug),
            'lastmod' => optional($item->updated_at)->toAtomString() ?? now()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.6',
        ];
    }

    $xml = view('sitemap', compact('urls'))->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/gioi-thieu', function () {
    return view('frontend.pages.gioi-thieu');
});
Route::get('/lien-he', [ContactController::class, 'showContactForm'])->name('lien-he');
Route::post('/lien-he', [ContactController::class, 'storeContact']);
Route::get('/refresh-captcha', [ContactController::class, 'refreshCaptcha']);
Route::get('/noi-dung-yeu-cau', [ContactController::class, 'showRequestForm']);
Route::post('/noi-dung-yeu-cau', [ContactController::class, 'storeRequest']);
Route::get('/dich-vu', function () {
    return view('frontend.pages.dich-vu');
});
Route::get('/tin-tuc', function () {
    $news = News::orderByDesc('updated_at')->paginate(10);
    return view('frontend.pages.tin-tuc', compact('news'));
});
Route::get('/tin-tuc/{slug}', function (string $slug) {
    $article = News::where('slug', $slug)->firstOrFail();
    return view('frontend.pages.tin-tuc-detail', compact('article'));
});

Route::get('/cho-thue-nha-xuong', fn () => app(ListingController::class)->show('cho-thue-nha-xuong', request()));
Route::get('/cho-thue-kho', fn () => app(ListingController::class)->show('cho-thue-kho', request()));
Route::get('/cho-thue-mat-bang', fn () => app(ListingController::class)->show('cho-thue-mat-bang', request()));
Route::get('/dat-ban', fn () => app(ListingController::class)->show('dat-ban', request()));
Route::get('/nha-xuong-ban', fn () => app(ListingController::class)->show('nha-xuong-ban', request()));

Route::get('/danh-sach-quan-tam', function () {
    return view('frontend.pages.danh-sach-quan-tam');
});
Route::get('/tim-kiem', [ListingController::class, 'search']);
Route::get('/tin-dang/{slug}', [ListingController::class, 'propertyDetail']);

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/provinces', [LocationController::class, 'getProvinces'])->name('provinces');
    Route::get('/districts', [LocationController::class, 'getDistricts'])->name('districts');
    Route::get('/wards', [LocationController::class, 'getWards'])->name('wards');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', function () {
        $newsCount = \App\Models\News::count();
        $propertyCount = \App\Models\Property::count();
        $contactCount = \App\Models\Inquiry::contact()->count();
        $requestCount = \App\Models\Inquiry::request()->count();
        return view('admin.dashboard', compact('newsCount', 'propertyCount', 'contactCount', 'requestCount'));
    })->name('dashboard');

    Route::get('/tin-dang', [PropertyController::class, 'index'])->name('tin-dang.index');
    Route::get('/tin-dang/tao', [PropertyController::class, 'create'])->name('tin-dang.create');
    Route::post('/tin-dang', [PropertyController::class, 'store'])->name('tin-dang.store');
    Route::get('/tin-dang/{tin_dang}/sua', [PropertyController::class, 'edit'])->name('tin-dang.edit');
    Route::put('/tin-dang/{tin_dang}', [PropertyController::class, 'update'])->name('tin-dang.update');
    Route::delete('/tin-dang/{tin_dang}', [PropertyController::class, 'destroy'])->name('tin-dang.destroy');

    Route::get('/tin-tuc', [NewsController::class, 'index'])->name('tin-tuc.index');
    Route::get('/tin-tuc/tao', [NewsController::class, 'create'])->name('tin-tuc.create');
    Route::post('/tin-tuc', [NewsController::class, 'store'])->name('tin-tuc.store');
    Route::get('/tin-tuc/{article}/sua', [NewsController::class, 'edit'])->name('tin-tuc.edit');
    Route::put('/tin-tuc/{article}', [NewsController::class, 'update'])->name('tin-tuc.update');
    Route::delete('/tin-tuc/{article}', [NewsController::class, 'destroy'])->name('tin-tuc.destroy');

    Route::get('/lien-he', [InquiryController::class, 'indexContact'])->name('lien-he.index');

    Route::get('/noi-dung-yeu-cau', [InquiryController::class, 'indexRequest'])->name('noi-dung-yeu-cau.index');

    Route::get('/cai-dat', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/cai-dat', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('/sliders/tao', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/sliders/{slider}/sua', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::put('/sliders/{slider}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('/sliders/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');

    Route::post('/editor/upload-image', [EditorImageController::class, 'upload'])->name('editor.upload-image');
});
