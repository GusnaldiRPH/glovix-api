<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetPrice extends Model
{
    protected $fillable = [
        'asset_id',
        'price',
        'open',
        'high',
        'low',
        'volume',
        'price_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'open' => 'decimal:2',
        'high' => 'decimal:2',
        'low' => 'decimal:2',
        'volume' => 'decimal:2',
        'price_date' => 'datetime',
    ];

    /**
     * Relationship ke Asset
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Helper method: Get historical prices untuk chart
     */
    public static function getChartData($assetId, $days = 30)
    {
        $startDate = now()->subDays($days);
        
        return static::where('asset_id', $assetId)
            ->where('price_date', '>=', $startDate)
            ->orderBy('price_date', 'asc')
            ->get(['price', 'price_date']);
    }
}