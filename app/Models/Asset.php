<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'type',
        'current_price',
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
    ];

    // Existing relationship
    public function userAssets()
    {
        return $this->hasMany(UserAsset::class);
    }

    // 👇 TAMBAHKAN INI - Relationship ke historical prices
    public function prices()
    {
        return $this->hasMany(AssetPrice::class);
    }

    // 👇 TAMBAHKAN INI - Get latest price
    public function latestPrice()
    {
        return $this->hasOne(AssetPrice::class)->latestOfMany('price_date');
    }

    // 👇 TAMBAHKAN INI - Helper untuk get historical data
    public function getHistoricalPrices($days = 30)
    {
        return $this->prices()
            ->where('price_date', '>=', now()->subDays($days))
            ->orderBy('price_date', 'asc')
            ->get();
    }
}