<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\EducationalVideo;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $levels = Level::with(['videos' => function($query) {
            $query->orderBy('order');
        }])->get();
        
        $userLevel = Auth::user()->level;
        
        return view('user.education.index', compact('levels', 'userLevel'));
    }

    public function show($id)
    {
        $video = EducationalVideo::with('level')->findOrFail($id);
        $userProgress = UserProgress::where('user_id', Auth::id())
            ->where('video_id', $id)
            ->first();
        
        return view('user.education.show', compact('video', 'userProgress'));
    }

    public function complete($id)
    {
        $video = EducationalVideo::findOrFail($id);
        $user = Auth::user();
        
        $progress = UserProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]
        );
        
        if ($progress->wasRecentlyCreated) {
            $progress->is_completed = true;
            $progress->completed_at = now();
            $progress->save();
            
            $user->addExp($video->exp_reward);
            
            return redirect()->back()->with('success', 'Video selesai! Anda mendapat ' . $video->exp_reward . ' EXP');
        }
        
        return redirect()->back()->with('info', 'Video sudah diselesaikan sebelumnya');
    }
}