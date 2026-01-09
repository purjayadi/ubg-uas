@extends('layouts.app')

@section('title', 'Edit Foto Carousel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit Foto Carousel</div>
            <div class="card-body">
                <form action="{{ route('carousel.update', $image) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $image->title) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link (opsional)</label>
                        <input type="text" name="link" class="form-control" value="{{ old('link', $image->link) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $image->order) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        @if($image->image)
                            <div class="mb-2"><img src="{{ asset('storage/' . $image->image) }}" style="max-width:200px;"/></div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="active" value="1" class="form-check-input" {{ $image->active ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
