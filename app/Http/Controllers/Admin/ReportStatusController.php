<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportStatusRequest;
use App\Http\Requests\UpdateReportStatusRequest;
use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\ReportStatusRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class ReportStatusController extends Controller
{
    protected $reportStatusRepository;
    protected $reportRepository;

    public function __construct(ReportStatusRepositoryInterface $reportStatusRepository, ReportRepositoryInterface $reportRepository)
    {
        $this->reportStatusRepository = $reportStatusRepository;
        $this->reportRepository = $reportRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Report Statuses are displayed in the report show page, no need for index
        return redirect()->route('admin.reports.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if report_id is provided
        $reportId = request('report_id');
        if (!$reportId) {
            Swal::error('Error', 'Report ID is required');
            return redirect()->back();
        }

        // Get report
        $report = $this->reportRepository->getReportById($reportId);
        if (!$report) {
            Swal::error('Error', 'Report not found');
            return redirect()->route('admin.reports.index');
        }

        return view('pages.admin.report-statuses.create', compact('report'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportStatusRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/report-statuses', 'public');
        }

        // Create status
        $status = $this->reportStatusRepository->createStatus($data);

        Swal::success('Berhasil', 'Status laporan berhasil ditambahkan')
            ->autoClose(5000)
            ->timerProgressBar();

        return redirect()->route('admin.reports.show', $data['report_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = $this->reportStatusRepository->getStatusById($id);
        if (!$status) {
            Swal::error('Error', 'Status tidak ditemukan');
            return redirect()->route('admin.reports.index');
        }

        return view('pages.admin.report-statuses.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $status = $this->reportStatusRepository->getStatusById($id);
        if (!$status) {
            Swal::error('Error', 'Status tidak ditemukan');
            return redirect()->route('admin.reports.index');
        }

        $report = $status->report;
        return view('pages.admin.report-statuses.edit', compact('status', 'report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportStatusRequest $request, string $id)
    {
        $data = $request->validated();
        $status = $this->reportStatusRepository->getStatusById($id);

        if (!$status) {
            Swal::error('Error', 'Status tidak ditemukan');
            return redirect()->route('admin.reports.index');
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/report-statuses', 'public');
        }

        $this->reportStatusRepository->updateStatus($id, $data);

        Swal::success('Berhasil', 'Status laporan berhasil diperbarui')
            ->autoClose(5000)
            ->timerProgressBar();

        return redirect()->route('admin.reports.show', $status->report_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = $this->reportStatusRepository->getStatusById($id);
        if (!$status) {
            Swal::error('Error', 'Status tidak ditemukan');
            return redirect()->route('admin.reports.index');
        }

        $reportId = $status->report_id;
        $this->reportStatusRepository->deleteStatus($id);

        Swal::success('Berhasil', 'Status laporan berhasil dihapus')
            ->autoClose(5000)
            ->timerProgressBar();

        return redirect()->route('admin.reports.show', $reportId);
    }
}
