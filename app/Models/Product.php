<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'stock',
        'sizes', 'images', 'discount_type', 'discount_value', 'is_active',
    ];

    protected $casts = [
        'sizes' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    // visible on frontend
    public function scopeVisible($q)
    {
        return $q->where('is_active', true)->where('stock', '>', 0);
    }

    public function finalPrice(): int
    {
        if ($this->discount_type === 'none' || $this->discount_value <= 0) {
            return $this->price;
        }

        if ($this->discount_type === 'fixed') {
            return max(0, $this->price - $this->discount_value);
        }

        $discount = intdiv($this->price * $this->discount_value, 100);

        return max(0, $this->price - $discount);
    }
}
