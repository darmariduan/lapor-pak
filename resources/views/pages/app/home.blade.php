@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <h6 class="greeting">Hi, {{ Auth::user()->name ?? 'Lapor Pak' }}</h6>
    <h4 class="home-headline">Laporkan masalahmu dan kami segera atasi itu</h4>

    <div class="d-flex align-items-center gap-4 py-3 overflow-auto" id="category" style="white-space: nowrap;">

        @foreach ($categories as $category)
            <a href="{{ route('report.index', ['category' => $category->name]) }}" class="category d-inline-block">
                <div class="icon">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="icon">
                </div>
                <p>{{ $category->name }}</p>
            </a>
        @endforeach

    </div>

    <div class="py-3" id="reports">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Pengaduan terbaru</h6>
            <a href="{{ route('report.index') }}" class="text-primary text-decoration-none show-more">
                Lihat semua
            </a>
        </div>

        <div class="d-flex flex-column gap-3 mt-3">
            @foreach ($reports as $report)
                <div class="card card-report border-0 shadow-none">
                    <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                        <div class="card-body p-0">
                            <div class="card-report-image position-relative mb-2">
                                <img src="{{ asset('storage/' . $report->image) }}" alt="">
                                @if ($report->reportStatuses->last()->status === 'pending')
                                    <div class="badge-status pending">
                                        Pending
                                    </div>
                                @elseif (
                                    $report->reportStatuses->last()->status === 'on_process' ||
                                        $report->reportStatuses->last()->status === 'in_progress')
                                    <div class="badge-status on-process">
                                        Diproses
                                    </div>
                                @elseif ($report->reportStatuses->last()->status === 'resolved')
                                    <div class="badge-status resolved">
                                        Selesai
                                    </div>
                                @elseif ($report->reportStatuses->last()->status === 'rejected')
                                    <div class="badge-status rejected">
                                        Ditolak
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <div class="d-flex align-items-center ">
                                    <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                        class="icon me-2">
                                    <p class="text-primary city">
                                        {{ $report->address }}
                                    </p>
                                </div>

                                <p class="text-secondary date">
                                    {{ $report->created_at->format('d F Y') }}
                                </p>
                            </div>

                            <h1 class="card-title">
                                {{ $report->title }}
                            </h1>
                        </div>
                    </a>
                </div>
            @endforeach


        </div>
    </div>
@endsection
