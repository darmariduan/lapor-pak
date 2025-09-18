<?php

namespace App\Repositories;

use App\Models\Report;
use App\Interfaces\ReportRepositoryInterface;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllReports()
    {
        return Report::all();
    }

    public function getLatestReports()
    {
        return Report::latest()->take(5)->get();
    }

    public function getReportsByResidentId(string $status)
    {
        return Report::where('resident_id', Auth::user()->resident->id)
            ->whereHas('reportStatuses', function (Builder $query) use ($status) {
                $query->where('status', $status)
                    ->whereIn('id', function ($subquery) {
                        $subquery->selectRaw('MAX(id)')
                            ->from('report_statuses')
                            ->groupBy('report_id');
                    });
            })->get();
    }
    public function getReportByCode(string $code)
    {
        return Report::where('code', $code)->first();
    }

    public function getReportById(string $id)
    {
        return Report::findOrFail($id);
    }

    public function getReportByCategory(string $category)
    {
        $category = ReportCategory::where('name', $category)->first();
        return Report::where('report_category_id', $category->id)->get();
    }

    public function createReport(array $data)
    {
        $report = Report::create($data);
        $report->reportStatuses()->create(['status' => 'pending', 'description' => 'Laporan telah dibuat dan menunggu verifikasi.']);
        return $report;
    }

    public function updateReport(string $id, array $data)
    {
        $report = Report::findOrFail($id);
        $report->update($data);
        return $report;
    }

    public function deleteReport(string $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return $report;
    }
}
