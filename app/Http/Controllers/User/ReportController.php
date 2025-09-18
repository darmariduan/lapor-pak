<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Interfaces\ReportRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert as Swal;
use App\Interfaces\ReportCategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private ReportRepositoryInterface $reportRepository;
    private ReportCategoryRepositoryInterface $reportCategoryRepository;

    public function __construct(ReportRepositoryInterface $reportRepository, ReportCategoryRepositoryInterface $reportCategoryRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->reportCategoryRepository = $reportCategoryRepository;
    }

    public function index(Request $request)
    {
        if ($request->category) {
            $reports = $this->reportRepository->getReportByCategory($request->category);
        } else {
            $reports = $this->reportRepository->getAllReports();
        }
        return view('pages.app.report.index', compact('reports'));
    }

    public function show($code)
    {
        $report = $this->reportRepository->getReportByCode($code);
        return view('pages.app.report.show', compact('report'));
    }

    public function take()
    {
        return view('pages.app.report.take');
    }

    public function myReport(Request $request)
    {
        $reports = $this->reportRepository->getReportsByResidentId($request->status);
        return view('pages.app.report.my-report', compact('reports'));
    }
    public function preview()
    {
        return view('pages.app.report.preview');
    }

    public function create()
    {
        $categories = $this->reportCategoryRepository->getAllCategories();
        return view('pages.app.report.create', compact('categories'));
    }

    public function store(StoreReportRequest $request)
    {
        $validated = $request->validated();
        // Generate unique code for the report
        $data['code'] = 'REP-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        $data['resident_id'] = Auth::user()->resident->id;

        $data['image'] = $request->file('image')->store('assets/report/image', 'public');

        $this->reportRepository->createReport($data);

        Swal::success('Berhasil', 'Laporan berhasil dibuat')
            ->autoClose(5000)
            ->timerProgressBar();
        return redirect()->route('report.success');
    }

    public function success()
    {
        return view('pages.app.report.success');
    }
}
