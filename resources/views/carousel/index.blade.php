@extends('layouts.app')

@section('title', 'Manage Carousel - RevResto')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Carousel</h2>
    <a href="{{ route('carousel.create') }}" class="btn btn-success">Tambah Foto Carousel</a>
</div>

@if($images->count())
    <div class="row g-4">
        @foreach($images as $img)
            <div class="col-md-4">
                <div class="card">
                    @if($img->image)
                        <img src="{{ asset('storage/' . $img->image) }}" class="card-img-top" style="height:200px;object-fit:cover;">
                    @else
                        <div style="height:200px;background:#eee;display:flex;align-items:center;justify-content:center;">No Image</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $img->title ?? 'Untitled' }}</h5>
                        <p class="text-muted">Order: {{ $img->order }} • Active: {{ $img->active ? 'Yes' : 'No' }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('carousel.edit', $img) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('carousel.destroy', $img) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">Belum ada foto carousel. Tambah foto untuk menampilkan carousel.</div>
@endif

@endsection
