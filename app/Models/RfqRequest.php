<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'company_name',
        'contact_email',
        'contact_phone',
        'target_quantity',
        'target_unit_price',
        'delivery_deadline',
        'packaging_specs',
        'status',
    ];

    protected $casts = [
        'target_quantity' => 'integer',
        'target_unit_price' => 'decimal:2',
        'delivery_deadline' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
