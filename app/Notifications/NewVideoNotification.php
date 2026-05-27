<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewVideoNotification extends Notification
{
    use Queueable;

    protected $video;

    public function __construct($video)
    {
        $this->video = $video;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'    => 'new_video',
            'title'   => 'Video Edukasi Baru! 🎬',
            'message' => 'Video baru telah tersedia: ' . $this->video->title,
            'url'     => '/education/' . $this->video->id,
            'icon'    => 'fas fa-play-circle',
            'color'   => 'green',
        ];
    }
}