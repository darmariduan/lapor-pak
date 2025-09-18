@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Total Kategori Laporan Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Kategori Laporan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCategories ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Laporan Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Laporan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReports ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Masyarakat Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Masyarakat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalResidents ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Laporan Pending -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Laporan Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingReports ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Diproses -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Laporan Diproses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inProgressReports ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cogs fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Selesai -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Laporan Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resolvedReports ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Ditolak -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Laporan Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejectedReports ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Terbaru</h6>
            </div>
            <div class="card-body">
                @if (isset($latestReports) && $latestReports->isNotEmpty())
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
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestReports as $index => $report)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $report->code }}</td>
                                        <td>{{ Str::limit($report->title, 30) }}</td>
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
                                        <td>{{ $report->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada laporan terbaru.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
