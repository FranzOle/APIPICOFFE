<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'cashier_id',
        'subtotal',
        'tax',
        'total',
        'payment_method',
        'order_date',
        'status',
    ];

    protected $casts = [
        'subtotal'   => 'integer',
        'tax'        => 'integer',
        'total'      => 'integer',
        'order_date' => 'datetime',
    ];

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'APC-';
        $latest = self::withTrashed()->orderByDesc('id')->first();
        $next   = $latest ? ((int) ltrim(str_replace($prefix, '', $latest->order_number), '0') + 1) : 1;
        return $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}
