@extends('layouts.admin')

@section('page-title', 'Edit Berita')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $news->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                @if($news->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($news->image) }}" alt="Current" width="200" class="rounded">
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                       accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Konten <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                          rows="10" required>{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_published" class="form-check-input" 
                           id="published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label" for="published">
                        Publikasikan
                    </label>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection