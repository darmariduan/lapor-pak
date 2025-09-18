<?php

namespace App\Interfaces;

interface ReportRepositoryInterface
{
    public function getAllReports();
    public function getLatestReports();
    public function getReportsByResidentId(string $status);
    public function getReportById(string $id);
    public function getReportByCode(string $code);
    public function getReportByCategory(string $category);
    public function createReport(array $data);
    public function updateReport(string $id, array $data);
    public function deleteReport(string $id);
}
