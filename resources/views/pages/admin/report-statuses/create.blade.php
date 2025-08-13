@extends('layouts.admin')

@section('title', 'Tambah Status Laporan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-danger mb-3">Kembali</a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Status Laporan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.report-statuses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}">

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
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi Status</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Bukti (Opsional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
@endsection
