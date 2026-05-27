<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAsset extends Model
{
    protected $fillable = [
        'user_id',
        'asset_id',
        'quantity',
        'average_price',
        'purchase_price',
    ];

    protected $casts = [
        'quantity' => 'decimal:8',
        'average_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}