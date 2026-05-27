<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalVideo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'level_id',
        'exp_reward',
        'duration',
        'order',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class, 'video_id');
    }

    public function getEmbedUrlAttribute()
    {
        // Convert YouTube URL to embed URL
        if (strpos($this->video_url, 'youtube.com') !== false) {
            preg_match('/[?&]v=([^&]+)/', $this->video_url, $matches);
            return isset($matches[1]) ? 'https://www.youtube.com/embed/' . $matches[1] : $this->video_url;
        }
        return $this->video_url;
    }
}