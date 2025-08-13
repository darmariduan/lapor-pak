@extends('layouts.admin')

@section('title', 'Edit Status Laporan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <a href="{{ route('admin.reports.show', $status->report_id) }}" class="btn btn-danger mb-3">Kembali</a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Status Laporan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.report-statuses.update', $status->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="report_id" value="{{ $status->report_id }}">

                    <div class="form-group">
                        <label for="report_detail">Detail Laporan</label>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $report->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Kode: {{ $report->code }}</h6>
                                <p class="card-text">{{ $report->description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="pending" {{ $status->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $status->status == 'in_progress' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="resolved" {{ $status->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ $status->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi Status</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $status->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Bukti (Opsional)</label>
                        @if ($status->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $status->image) }}" alt="Bukti Status" width="200">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
