<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name',
        'min_exp',
        'max_exp',
        'description',
    ];

    public function videos()
    {
        return $this->hasMany(EducationalVideo::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'current_level_id');
    }
}