@extends('layouts.admin')

@section('page-title', 'Kelola Video Edukasi')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.videos.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Video
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Level</th>
                        <th>EXP Reward</th>
                        <th>Durasi</th>
                        <th>Urutan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                    <tr>
                        <td>{{ $video->id }}</td>
                        <td>{{ Str::limit($video->title, 50) }}</td>
                        <td>
                            <span class="badge bg-info">{{ $video->level->name }}</span>
                        </td>
                        <td>+{{ $video->exp_reward }} EXP</td>
                        <td>{{ $video->duration ?? '-' }} menit</td>
                        <td>{{ $video->order }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada video</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $videos->links() }}
    </div>
</div>
@endsection