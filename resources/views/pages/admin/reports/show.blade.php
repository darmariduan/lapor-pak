@extends('layouts.admin')

@section('title', 'Detail Laporan')

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
                <h6 class="m-0 font-weight-bold text-primary">Detail Laporan</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Kode Laporan</th>
                        <td>{{ $report->code }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $report->title }}</td>
                    </tr>
                    <tr>
                        <th>Pelapor</th>
                        <td>{{ $report->resident->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $report->reportCategory->name }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $report->description }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $report->address }}</td>
                    </tr>
                    <tr>
                        <th>Koordinat</th>
                        <td>
                            @if ($report->latitude && $report->longitude)
                                Latitude: {{ $report->latitude }}, Longitude: {{ $report->longitude }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Map</th>
                        <td>
                            @if ($report->latitude && $report->longitude)
                                <div id="map"></div>
                            @else
                                <span class="text-muted">Tidak ada koordinat</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Foto/Gambar</th>
                        <td>
                            @if ($report->image)
                                <img src="{{ asset('storage/' . $report->image) }}" alt="Gambar Laporan" width="300">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status Terakhir</th>
                        <td>
                            @if ($report->reportStatuses->count() > 0)
                                @php
                                    $lastStatus = $report->reportStatuses->last();
                                @endphp
                                @if ($lastStatus->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($lastStatus->status == 'in_progress')
                                    <span class="badge badge-info">Diproses</span>
                                @elseif ($lastStatus->status == 'resolved')
                                    <span class="badge badge-success">Selesai</span>
                                @elseif ($lastStatus->status == 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            @else
                                <span class="badge badge-secondary">Belum ada status</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Riwayat Status -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Status</h6>
                <a href="{{ route('admin.report-statuses.create', ['report_id' => $report->id]) }}"
                    class="btn btn-sm btn-primary">Tambah Status</a>
            </div>
            <div class="card-body">
                @if ($report->reportStatuses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Bukti</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report->reportStatuses as $index => $status)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($status->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($status->status == 'in_progress')
                                                <span class="badge badge-info">Diproses</span>
                                            @elseif ($status->status == 'resolved')
                                                <span class="badge badge-success">Selesai</span>
                                            @elseif ($status->status == 'rejected')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $status->description }}</td>
                                        <td>
                                            @if ($status->image)
                                                <img src="{{ asset('storage/' . $status->image) }}" alt="Bukti Status"
                                                    width="100">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $status->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.report-statuses.edit', $status->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.report-statuses.show', $status->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form id="delete-form-{{ $status->id }}"
                                                action="{{ route('admin.report-statuses.destroy', $status->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $status->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <p class="text-muted">Belum ada riwayat status</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // Inisialisasi peta jika ada koordinat
        @if ($report->latitude && $report->longitude)
            var map = L.map('map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map)
                .bindPopup('{{ $report->title }}')
                .openPopup();
        @endif

        // SweetAlert untuk konfirmasi hapus
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            if (deleteButtons.length > 0) {
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = this.getAttribute('data-id');

                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: "Apakah Anda yakin ingin menghapus status ini?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('delete-form-' + id).submit();
                            }
                        });
                    });
                });
            }
        });
    </script>
@endsection
