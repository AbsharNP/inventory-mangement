<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity'   => 'integer',
            'expires_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope: items expiring within the next N days.
     */
    public function scopeExpiringWithin($query, int $days = 7)
    {
        return $query->whereNotNull('expires_at')
                     ->where('expires_at', '>=', now())
                     ->where('expires_at', '<=', now()->addDays($days));
    }
}
