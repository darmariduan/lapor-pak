@extends('layouts.admin')

@section('title', 'Tambah Data Laporan')

@section('styles')
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <a href="{{ route('admin.reports.index') }}" class="btn btn-danger mb-3">Kembali</a>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data Laporan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="resident_id">Pelapor</label>
                        <select name="resident_id" id="resident_id"
                            class="form-control @error('resident_id') is-invalid @enderror">
                            <option value="">Pilih Pelapor</option>
                            @foreach ($residents as $resident)
                                <option value="{{ $resident->id }}"
                                    {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                                    {{ $resident->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('resident_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="report_category_id">Kategori Laporan</label>
                        <select name="report_category_id" id="report_category_id"
                            class="form-control @error('report_category_id') is-invalid @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('report_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('report_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Judul Laporan</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Foto/Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Lokasi (Klik pada peta untuk memilih)</label>
                        <div id="map" class="mb-3"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude" name="latitude" value="{{ old('latitude') }}" readonly>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" value="{{ old('longitude') }}" readonly>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set default coordinates (center of Indonesia/Jakarta)
            const defaultLat = {{ old('latitude', '-6.200000') }};
            const defaultLng = {{ old('longitude', '106.816666') }};

            // Initialize the map
            const map = L.map('map').setView([defaultLat, defaultLng], 13);

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add marker if coordinates are already set
            let marker;
            if (defaultLat != '-6.200000' || defaultLng != '106.816666') {
                marker = L.marker([defaultLat, defaultLng]).addTo(map);
            }

            // Handle click on map to set marker and update coordinates
            map.on('click', function(e) {
                // Update the marker
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);

                // Update form fields with coordinates (rounded to 6 decimal places)
                document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(6);

                // Optional: If you want to try to get the address from coordinates using reverse geocoding
                // You could add a call to a service like Nominatim here
            });

            // Add scale control
            L.control.scale().addTo(map);

            // Force a map resize after it's visible to fix rendering issues
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
@endsection
