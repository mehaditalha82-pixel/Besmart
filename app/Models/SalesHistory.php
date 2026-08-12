<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'units_sold',
        'revenue',
        'sale_date',
    ];

    protected $casts = [
        'units_sold' => 'integer',
        'revenue' => 'decimal:2',
        'sale_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
