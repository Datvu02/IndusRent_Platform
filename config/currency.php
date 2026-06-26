<?php

return [
    'code' => env('CURRENCY_CODE', 'USD'),
    'symbol' => env('CURRENCY_SYMBOL', '$'),
    /** Tỷ giá quy đổi VNĐ → USD (dùng một lần khi migrate dữ liệu cũ). */
    'vnd_to_usd_rate' => (float) env('CURRENCY_VND_TO_USD_RATE', 25000),
];
