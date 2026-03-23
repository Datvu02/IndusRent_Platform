<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $table = 'inquiries';

    protected $fillable = [
        'type',
        'name',
        'company',
        'nationality',
        'address',
        'email',
        'phone',
        'message',
        'property_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeContact($query)
    {
        return $query->where('type', 'contact');
    }

    public function scopeRequest($query)
    {
        return $query->where('type', 'request');
    }
}
