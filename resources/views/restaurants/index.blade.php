@extends('layouts.app')

@section('title', 'Daftar Restoran - RevResto')

@section('styles')
<style>

    /* Removed carousel styles (user will add manual carousel). */

    /* Responsive grid layout: mobile (1 col) → tablet (2 col) → desktop (3 col) */
    .restaurants-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin: 2rem auto 0;
        width: 100%;
        max-width: 100%;
        align-items: start;
        padding: 0 1rem;
    }

    /* Tablet: 2 columns */
    @media (min-width: 768px) {
        .restaurants-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 900px;
            gap: 1.75rem;
        }
    }

    /* Desktop: 3 columns */
    @media (min-width: 1024px) {
        .restaurants-grid {
            grid-template-columns: repeat(3, 1fr);
            max-width: 1300px;
            gap: 2rem;
        }
    }

    /* Large desktop: auto center */
    @media (min-width: 1400px) {
        .restaurants-grid {
            max-width: 1400px;
        }
    }

    .card-restaurant {
        transition: all 0.28s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    
    .card-restaurant:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }
    
    .card-restaurant img {
        display: block;
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    .card-restaurant .card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .card-restaurant .btn {
        margin-top: auto;
    }

    /* Hide any leftover carousel markup that might be causing the coral panel */
    .carousel-container,
    .carousel,
    .carousel-item {
        display: none !important;
    }

    /* Hero Section */
    .hero-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        background: linear-gradient(90deg, #682b1e 0%, #682b1e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
    }

    .hero-section p {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2rem;
    }

    /* Search & Filter Section */
    .search-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .search-section .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        padding: 0.7rem 1rem;
    }

    .search-section .form-control:focus {
        border-color:#682b1e;
        box-shadow: 0 0 12px rgba(255, 122, 69, 0.08);
    }

    .search-section .btn {
        border-radius: 10px;
        font-weight: 600;
        min-width: 120px;
    }

    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: #ccc;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #666;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #999;
    }

    /* Pagination */
    .pagination {
        margin-top: 3rem;
    }

    .page-link {
        color:#682b1e;
        border-radius: 8px;
        margin: 0 3px;
        font-size: 0.9rem;
    }

    .page-link:hover {
        color: white;
        background: linear-gradient(90deg, #682b1e 0%, #682b1e 100%);
    }

    .page-item.active .page-link {
        background: linear-gradient(90deg, #682b1e 0%,#682b1e 100%);
        border: none;
    }

    /* Reduce arrow size in pagination */
    .pagination .page-link svg,
    .pagination .page-link i {
        font-size: 0.6rem;
        width: 0.6rem;
        height: 0.6rem;
    }
</style>
@endsection

@section('content')
<!-- Carousel removed per user request -->

<!-- Hero Section -->
<div class="hero-section">
    <h1><i class="fas fa-utensils me-3"></i>Jelajahi Restoran Terbaik</h1>
    <p>Temukan restoran pilihan dan baca review dari pengguna lain</p>
</div>

<!-- Search Section -->
<div class="search-section">
    <form action="{{ route('restaurants.search') }}" method="GET" class="d-flex gap-2 flex-grow-1">
        <input type="text" name="search" class="form-control" placeholder="🔍 Cari restoran, tipe masakan, atau lokasi..." value="{{ $search ?? '' }}" style="flex-grow: 1;">
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-search me-2"></i>Cari
        </button>
    </form>
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('restaurants.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Tambah Resto
            </a>
        @endif
    @endauth
</div>

<!-- Restaurants Grid -->
@if ($restaurants->count() > 0)
    <div class="restaurants">
        @foreach ($restaurants as $restaurant)
            <div class="card card-restaurant">
                <div class="card-image">
                    @if ($restaurant->image)
                        <img src="{{ Storage::url($restaurant->image) }}" alt="{{ $restaurant->name }}">
                    @else
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center" style="color: white; font-weight: 600;">
                            <i class="fas fa-image me-2"></i>Tidak ada gambar
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                    <p class="card-text text-muted small">
                        <i class="fas fa-utensils me-1"></i>{{ $restaurant->cuisine_type }}
                    </p>
                    <div class="mb-2">
                        <span class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($restaurant->rating))
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </span>
                        <small class="text-muted ms-1">
                            <i class="fas fa-comment me-1"></i>({{ $restaurant->reviews->count() }})
                        </small>
                    </p>
                    <p class="card-text small text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($restaurant->address, 40) }}
                    </p>
                    <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
       {{ $restaurants->links('vendor.pagination.resto') }}
    </div>
@else
    <div class="card border-0 empty-state">
        <i class="fas fa-search"></i>
        <h5>Tidak ada restoran yang ditemukan</h5>
        <p>Coba cari dengan keyword lain atau tambahkan restoran baru</p>
    </div>
@endif
@endsection