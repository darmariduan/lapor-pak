<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resident;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ReportCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\ResidentRepositoryInterface;
use App\Interfaces\ReportCategoryRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class ReportController extends Controller
{
    private ReportRepositoryInterface $reportRepository;
    private ResidentRepositoryInterface $residentRepository;
    private ReportCategoryRepositoryInterface $reportCategoryRepository;

    public function __construct(ReportRepositoryInterface $reportRepository, ResidentRepositoryInterface $residentRepository, ReportCategoryRepositoryInterface $reportCategoryRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->residentRepository = $residentRepository;
        $this->reportCategoryRepository = $reportCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = $this->reportRepository->getAllReports();
        return view('pages.admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $residents = $this->residentRepository->getAllResidents();
        $categories = $this->reportCategoryRepository->getAllCategories();
        return view('pages.admin.reports.create', compact('residents', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();

        // Generate unique code for the report
        $data['code'] = 'REP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/reports', 'public');
        }

        $this->reportRepository->createReport($data);

        Swal::success('Berhasil', 'Laporan berhasil dibuat')
            ->autoClose(5000)
            ->timerProgressBar();

        return redirect()->route('admin.reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = $this->reportRepository->getReportById($id);
        return view('pages.admin.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = $this->reportRepository->getReportById($id);
        $residents = $this->residentRepository->getAllResidents();
        $categories = $this->reportCategoryRepository->getAllCategories();

        return view('pages.admin.reports.edit', compact('report', 'residents', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, string $id)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/reports', 'public');
        }

        $this->reportRepository->updateReport($id, $data);

        Swal::success('Berhasil', 'Laporan berhasil diperbarui')
            ->autoClose(5000)
            ->timerProgressBar();

        return redirect()->route('admin.reports.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->reportRepository->deleteReport($id);

        Swal::success('Berhasil', 'Laporan berhasil dihapus')
            ->autoClose(5000)
            ->timerProgressBar();

        return redirect()->route('admin.reports.index');
    }
}
