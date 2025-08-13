@extends('layouts.admin')

@section('title', 'Data Laporan')

@section('content')
    <div class="container-fluid">

        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary mb-3">Tambah Data</a>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pelapor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $report->code }}</td>
                                    <td>{{ $report->title }}</td>
                                    <td>{{ $report->reportCategory->name }}</td>
                                    <td>{{ $report->resident->user->name }}</td>
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
                                    <td>
                                        <a href="{{ route('admin.reports.edit', $report->id) }}"
                                            class="btn btn-warning">Edit</a>

                                        <a href="{{ route('admin.reports.show', $report->id) }}"
                                            class="btn btn-info">Show</a>

                                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
