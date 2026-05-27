<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'total_exp',
        'current_level_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'current_level_id');
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function userAssets()
    {
        return $this->hasMany(UserAsset::class);
    }

    public function addExp($exp)
    {
        $this->total_exp += $exp;
        $this->checkLevelUp();
        $this->save();
    }

    private function checkLevelUp()
    {
        $nextLevel = Level::where('min_exp', '<=', $this->total_exp)
            ->where('max_exp', '>=', $this->total_exp)
            ->first();
        
        if ($nextLevel && $nextLevel->id != $this->current_level_id) {
            $this->current_level_id = $nextLevel->id;
        }
    }
}