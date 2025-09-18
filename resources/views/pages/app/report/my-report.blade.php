@extends('layouts.no-nav')

@section('title', 'Laporan Saya')
@section('content')
    <div class="max-w-screen-sm mx-auto bg-white min-vh-100 p-3">
        <ul class="nav nav-tabs" id="filter-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}"
                    href="{{ url()->current() }}?status=pending" id="terkirim-tab" role="tab">Terkirim</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'on_process' ? 'active' : '' }}"
                    href="{{ url()->current() }}?status=on_process" id="diproses-tab" role="tab">Diproses</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'resolved' ? 'active' : '' }}"
                    href="{{ url()->current() }}?status=resolved" id="selesai-tab" role="tab">Selesai</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'rejected' ? 'active' : '' }}"
                    href="{{ url()->current() }}?status=rejected" id="ditolak-tab" role="tab">Ditolak</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="terkirim-tab-pane" role="tabpanel" aria-labelledby="terkirim-tab"
                tabindex="0">
                <div class="d-flex flex-column gap-3 mt-3">
                    @forelse ($reports as $report)
                        <div class="card card-report border-0 shadow-none">
                            <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                                <div class="card-body p-0">
                                    <div class="card-report-image position-relative mb-2">
                                        <img src="{{ asset('storage/' . $report->image) }}" alt="">
                                        @php $lastStatus = $report->reportStatuses->last(); @endphp
                                        @if ($lastStatus && $lastStatus->status === 'pending')
                                            <div class="badge-status pending">
                                                Pending
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-end mb-2">
                                        <div class="d-flex align-items-center ">
                                            <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                                class="icon me-2">
                                            <p class="text-primary city">
                                                {{ \Str::substr($report->address, 0, 20) }}...
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
                    @empty
                        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                            id="no-reports">
                            <div id="lottie"></div>
                            <h5 class="mt-3">Belum ada laporan</h5>
                            <a href="{{ route('report.create') }}" class="btn btn-primary py-2 px-4 mt-3">
                                Buat Laporan
                            </a>
                        </div>
                    @endforelse


                </div>

                <div class="tab-pane fade" id="diproses-tab-pane" role="tabpanel" aria-labelledby="diproses-tab"
                    tabindex="0">
                    <div class="d-flex flex-column gap-3 mt-3">
                        @forelse ($reports as $report)
                            <div class="card card-report border-0 shadow-none">
                                <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                                    <div class="card-body p-0">
                                        <div class="card-report-image position-relative mb-2">
                                            <img src="{{ asset('storage/' . $report->image) }}" alt="">
                                            @php $lastStatus = $report->reportStatuses->last(); @endphp
                                            @if ($lastStatus && ($lastStatus->status === 'on_process' || $lastStatus->status === 'in_progress'))
                                                <div class="badge-status on-process">
                                                    Diproses
                                                </div>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <div class="d-flex align-items-center ">
                                                <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                                    class="icon me-2">
                                                <p class="text-primary city">
                                                    {{ \Str::substr($report->address, 0, 20) }}...
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
                        @empty
                            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                                id="no-reports-diproses">
                                <div id="lottie-diproses"></div>
                                <h5 class="mt-3">Belum ada laporan yang diproses</h5>
                                <a href="{{ route('report.create') }}" class="btn btn-primary py-2 px-4 mt-3">
                                    Buat Laporan
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="tab-pane fade" id="selesai-tab-pane" role="tabpanel" aria-labelledby="selesai-tab"
                    tabindex="0">
                    <div class="d-flex flex-column gap-3 mt-3">
                        @forelse ($reports as $report)
                            <div class="card card-report border-0 shadow-none">
                                <a href="{{ route('report.show', $report->code) }}" class="text-decoration-none text-dark">
                                    <div class="card-body p-0">
                                        <div class="card-report-image position-relative mb-2">
                                            <img src="{{ asset('storage/' . $report->image) }}" alt="">
                                            @php $lastStatus = $report->reportStatuses->last(); @endphp
                                            @if ($lastStatus && $lastStatus->status === 'resolved')
                                                <div class="badge-status resolved">
                                                    Selesai
                                                </div>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <div class="d-flex align-items-center ">
                                                <img src="{{ asset('assets/app/images/icons/MapPin.png') }}"
                                                    alt="map pin" class="icon me-2">
                                                <p class="text-primary city">
                                                    {{ \Str::substr($report->address, 0, 20) }}...
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
                        @empty
                            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                                id="no-reports-selesai">
                                <div id="lottie-selesai"></div>
                                <h5 class="mt-3">Belum ada laporan yang selesai</h5>
                                <a href="{{ route('report.create') }}" class="btn btn-primary py-2 px-4 mt-3">
                                    Buat Laporan
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="tab-pane fade" id="ditolak-tab-pane" role="tabpanel" aria-labelledby="ditolak-tab"
                    tabindex="0">
                    <div class="d-flex flex-column gap-3 mt-3">
                        @forelse ($reports as $report)
                            <div class="card card-report border-0 shadow-none">
                                <a href="{{ route('report.show', $report->code) }}"
                                    class="text-decoration-none text-dark">
                                    <div class="card-body p-0">
                                        <div class="card-report-image position-relative mb-2">
                                            <img src="{{ asset('storage/' . $report->image) }}" alt="">
                                            @php $lastStatus = $report->reportStatuses->last(); @endphp
                                            @if ($lastStatus && $lastStatus->status === 'rejected')
                                                <div class="badge-status rejected">
                                                    Ditolak
                                                </div>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <div class="d-flex align-items-center ">
                                                <img src="{{ asset('assets/app/images/icons/MapPin.png') }}"
                                                    alt="map pin" class="icon me-2">
                                                <p class="text-primary city">
                                                    {{ \Str::substr($report->address, 0, 20) }}...
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
                        @empty
                            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh"
                                id="no-reports-ditolak">
                                <div id="lottie-ditolak"></div>
                                <h5 class="mt-3">Belum ada laporan yang ditolak</h5>
                                <a href="{{ route('report.create') }}" class="btn btn-primary py-2 px-4 mt-3">
                                    Buat Laporan
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
        <script>
            var animation = bodymovin.loadAnimation({
                container: document.getElementById('lottie'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '{{ asset('assets/app/lottie/not-found.json') }}'
            })
        </script>
    @endsection
