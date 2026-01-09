@extends('layouts.app')

@section('title', $restaurant->name . ' - RevResto')

@section('content')
<div class="row">
    <div class="col-md-4">
        @if ($restaurant->image)
            <img src="{{ asset('storage/' . $restaurant->image) }}" class="img-fluid rounded" alt="{{ $restaurant->name }}">
        @else
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                <span>Tidak ada gambar</span>
            </div>
        @endif
    </div>
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h1>{{ $restaurant->name }}</h1>
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="btn-group">
                        <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
        <div class="mb-3">
            <span class="stars h4">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($restaurant->rating))
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </span>
            <span class="text-muted">({{ $restaurant->reviews->count() }} review)</span>
        </div>
        
        <p><strong>Tipe Masakan:</strong> {{ $restaurant->cuisine_type }}</p>
        <p><strong>Alamat:</strong> {{ $restaurant->address }}</p>
        <p><strong>Telepon:</strong> {{ $restaurant->phone }}</p>
        
        @if ($restaurant->description)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Deskripsi</h5>
                    <p>{{ $restaurant->description }}</p>
                </div>
            </div>
        @endif

        @if ($restaurant->latitude && $restaurant->longitude)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-map-marker-alt me-2"></i>Lokasi</h5>
                    <iframe width="100%" height="400" frameborder="0" style="border:0;border-radius:8px;" src="https://www.google.com/maps?q={{ $restaurant->latitude }},{{ $restaurant->longitude }}&z=15&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        @else
            {{-- <div class="card mb-4 border-warning">
                <div class="card-body text-muted">
                    <i class="fas fa-map-marker-alt me-2"></i>Informasi lokasi belum tersedia
                </div>
            </div> --}}
        @endif

        @auth
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Tulis Review</h5>
                    <form action="{{ route('reviews.store', $restaurant) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-control" required>
                                <option value="">Pilih rating</option>
                                <option value="1">1 - Sangat Buruk</option>
                                <option value="2">2 - Buruk</option>
                                <option value="3">3 - Cukup</option>
                                <option value="4">4 - Baik</option>
                                <option value="5">5 - Sangat Baik</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Komentar</label>
                            <textarea name="comment" class="form-control" rows="4" required placeholder="Tulis review Anda..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto (opsional)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Review</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">Login</a> untuk menulis review
            </div>
        @endauth
    </div>
</div>

<hr class="my-5">

<h2>Review ({{ $restaurant->reviews->count() }})</h2>

@if ($restaurant->reviews->count() > 0)
    @foreach ($restaurant->reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title">{{ $review->user->name }}</h5>
                        <div class="stars text-warning mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        <p class="card-text">{{ $review->comment }}</p>
                        @if ($review->photo)
                            <div class="mt-2 mb-2">
                                <img src="{{ asset('storage/' . $review->photo) }}" alt="Foto review" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                            </div>
                        @endif
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    @auth
                        @if (Auth::id() === $review->user_id)
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="text-muted">Belum ada review. Jadilah yang pertama!</p>
@endif

<div class="mt-4">
    <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
</div>
@endsection
