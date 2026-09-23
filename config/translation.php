<?php

return [
    /** MyMemory free API: tối đa ~500 ký tự mỗi request. */
    'max_chunk_length' => (int) env('TRANSLATION_MAX_CHUNK', 450),
    /** Nghỉ giữa các request khi dịch nội dung dài (microseconds). */
    'chunk_delay_us' => (int) env('TRANSLATION_CHUNK_DELAY_US', 350000),
    /** Nghỉ giữa lần dịch EN và ZH (microseconds). */
    'lang_switch_delay_us' => (int) env('TRANSLATION_LANG_SWITCH_DELAY_US', 500000),
    /** Số lần thử lại khi API trả về bản gốc. */
    'max_retries' => (int) env('TRANSLATION_MAX_RETRIES', 3),
    /** Nghỉ giữa các lần retry (microseconds, nhân với số lần thử). */
    'retry_delay_us' => (int) env('TRANSLATION_RETRY_DELAY_US', 500000),
];
