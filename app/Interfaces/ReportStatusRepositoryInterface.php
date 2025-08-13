<?php

namespace App\Interfaces;

interface ReportStatusRepositoryInterface
{
    public function getAllStatuses();
    public function getStatusById($id);
    public function createStatus(array $data);
    public function updateStatus($id, array $data);
    public function deleteStatus($id);
}
