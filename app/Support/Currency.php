<?php

namespace App\Support;

class Currency
{
    public static function format(float|int|string|null $amount): string
    {
        if ($amount === null || $amount === '') {
            return __('common.contact_price');
        }

        $amount = (float) $amount;
        $symbol = config('currency.symbol', '$');

        if ($amount >= 1_000_000) {
            $formatted = rtrim(rtrim(number_format($amount / 1_000_000, 1, '.', ','), '0'), '.');

            return $symbol.$formatted.'M';
        }

        return $symbol.number_format($amount, 0, '.', ',');
    }
}
