<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationalVideo;
use App\Models\Level;
use App\Models\User;
use App\Notifications\NewVideoNotification;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = EducationalVideo::with('level')->orderBy('level_id')->orderBy('order')->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('admin.videos.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'required|url',
            'level_id'    => 'required|exists:levels,id',
            'exp_reward'  => 'required|integer|min:1',
            'duration'    => 'nullable|integer|min:1',
            'order'       => 'nullable|integer|min:0',
        ]);

        $video = EducationalVideo::create($request->all());

        // ✅ Kirim notifikasi ke semua user (bukan admin)
        User::where('is_admin', false)->each(function ($user) use ($video) {
            $user->notify(new NewVideoNotification($video));
        });

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video edukasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $video  = EducationalVideo::findOrFail($id);
        $levels = Level::all();
        return view('admin.videos.edit', compact('video', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'required|url',
            'level_id'    => 'required|exists:levels,id',
            'exp_reward'  => 'required|integer|min:1',
            'duration'    => 'nullable|integer|min:1',
            'order'       => 'nullable|integer|min:0',
        ]);

        $video = EducationalVideo::findOrFail($id);
        $video->update($request->all());

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video edukasi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $video = EducationalVideo::findOrFail($id);
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video edukasi berhasil dihapus!');
    }
}