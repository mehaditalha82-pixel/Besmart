<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'discount_price',
        'start_time',
        'end_time',
        'allocated_stock',
        'sold_stock',
    ];

    protected $casts = [
        'discount_price' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'allocated_stock' => 'integer',
        'sold_stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getIsActiveAttribute(): bool
    {
        $now = now();
        return $this->start_time <= $now && $this->end_time >= $now;
    }
}
