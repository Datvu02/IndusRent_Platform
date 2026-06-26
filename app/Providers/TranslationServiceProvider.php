<?php

namespace App\Providers;

use App\Models\Slider;
use App\Observers\SliderObserver;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Slider::observe(SliderObserver::class);
    }
}
