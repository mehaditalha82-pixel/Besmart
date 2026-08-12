<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'category_id',
        'retail_price',
        'stock_quantity',
        'moq',
        'specifications',
        'is_featured',
        'description',
        'image_url',
    ];

    protected $casts = [
        'retail_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'moq' => 'integer',
        'specifications' => 'array',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function b2bPricings(): HasMany
    {
        return $this->hasMany(B2bPricing::class)->orderBy('min_qty', 'asc');
    }

    public function flashDeals(): HasMany
    {
        return $this->hasMany(FlashDeal::class);
    }

    public function activeFlashDeal(): HasOne
    {
        return $this->hasOne(FlashDeal::class)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now());
    }

    public function salesHistories(): HasMany
    {
        return $this->hasMany(SalesHistory::class)->orderBy('sale_date', 'desc');
    }
}
