@extends('layouts.app')

@section('title', 'Edit Restoran - RevResto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Restoran</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Restoran</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $restaurant->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $restaurant->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" required value="{{ old('address', $restaurant->address) }}" id="inputAddress">
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" required value="{{ old('phone', $restaurant->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Masakan</label>
                        <input type="text" name="cuisine_type" class="form-control @error('cuisine_type') is-invalid @enderror" required value="{{ old('cuisine_type', $restaurant->cuisine_type) }}">
                        @error('cuisine_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        @if($restaurant->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="number" name="latitude" class="form-control @error('latitude') is-invalid @enderror" step="0.00000001" placeholder="Contoh: -6.200000" value="{{ old('latitude', $restaurant->latitude) }}" id="inputLatitude">
                                @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Gunakan Google Maps untuk cari koordinat</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="number" name="longitude" class="form-control @error('longitude') is-invalid @enderror" step="0.00000001" placeholder="Contoh: 106.816666" value="{{ old('longitude', $restaurant->longitude) }}" id="inputLongitude">
                                @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="mb-3">
                        <a id="mapPreviewLink" href="javascript:void(0)" class="btn btn-sm btn-outline-primary" style="display:none;" target="_blank">
                            <i class="fas fa-map-marker-alt me-1"></i>Buka di Google Maps
                        </a>
                        <small id="mapPreviewText" class="text-muted">Isi alamat atau koordinat untuk melihat preview peta.</small>
                    </div> --}}

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    function updateMapPreview() {
        const lat = document.getElementById('inputLatitude').value;
        const lon = document.getElementById('inputLongitude').value;
        const addr = document.getElementById('inputAddress').value;
        const link = document.getElementById('mapPreviewLink');
        const text = document.getElementById('mapPreviewText');

        let query = null;
        if (lat && lon) {
            query = lat + ',' + lon;
        } else if (addr) {
            query = addr;
        }

        if (query) {
            link.href = 'https://maps.google.com/?q=' + encodeURIComponent(query);
            link.style.display = 'inline-block';
            text.style.display = 'none';
        } else {
            link.style.display = 'none';
            text.style.display = 'inline';
        }
    }

    document.getElementById('inputLatitude').addEventListener('input', updateMapPreview);
    document.getElementById('inputLongitude').addEventListener('input', updateMapPreview);
    document.getElementById('inputAddress').addEventListener('input', updateMapPreview);
    window.addEventListener('load', updateMapPreview);
</script> --}}

@endsection
