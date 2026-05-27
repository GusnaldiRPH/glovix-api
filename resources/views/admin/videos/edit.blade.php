@extends('layouts.admin')

@section('page-title', 'Edit Video Edukasi')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.videos.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Judul Video <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $video->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="3">{{ old('description', $video->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">URL Video <span class="text-danger">*</span></label>
                <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" 
                       value="{{ old('video_url', $video->video_url) }}" required>
                @error('video_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Level <span class="text-danger">*</span></label>
                    <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" 
                                    {{ old('level_id', $video->level_id) == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">EXP Reward <span class="text-danger">*</span></label>
                    <input type="number" name="exp_reward" class="form-control @error('exp_reward') is-invalid @enderror" 
                           value="{{ old('exp_reward', $video->exp_reward) }}" min="1" required>
                    @error('exp_reward')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" 
                           value="{{ old('duration', $video->duration) }}" min="1">
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                           value="{{ old('order', $video->order) }}" min="0">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection