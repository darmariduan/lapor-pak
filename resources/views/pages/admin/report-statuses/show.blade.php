@extends('layouts.admin')

@section('title', 'Detail Status Laporan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <a href="{{ route('admin.reports.show', $status->report_id) }}" class="btn btn-danger mb-3">Kembali</a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Status Laporan</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Kode Laporan</th>
                        <td>{{ $status->report->code }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $status->description }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $status->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Bukti</th>
                        <td>
                            @if ($status->image)
                                <img src="{{ asset('storage/' . $status->image) }}" alt="Bukti Status" width="300">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('admin.report-statuses.edit', $status->id) }}" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger delete-btn" data-id="{{ $status->id }}">Hapus</button>
                    <form id="delete-form-{{ $status->id }}"
                        action="{{ route('admin.report-statuses.destroy', $status->id) }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            if (deleteButtons.length > 0) {
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = this.getAttribute('data-id');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Status laporan yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
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
