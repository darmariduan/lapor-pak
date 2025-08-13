<?php

namespace App\Repositories;

use App\Models\Report;
use App\Interfaces\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllReports()
    {
        return Report::all();
    }

    public function getReportById(string $id)
    {
        return Report::findOrFail($id);
    }

    public function createReport(array $data)
    {
        return Report::create($data);
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
