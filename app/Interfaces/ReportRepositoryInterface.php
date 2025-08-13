<?php

namespace App\Interfaces;

interface ReportRepositoryInterface
{
    public function getAllReports();
    public function getReportById(string $id);
    public function createReport(array $data);
    public function updateReport(string $id, array $data);
    public function deleteReport(string $id);
}
