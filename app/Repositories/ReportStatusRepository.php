<?php

namespace App\Repositories;

use App\Interfaces\ReportStatusRepositoryInterface;
use App\Models\ReportStatus;

class ReportStatusRepository implements ReportStatusRepositoryInterface
{
    public function getAllStatuses()
    {
        return ReportStatus::all();
    }

    public function getStatusById($id)
    {
        return ReportStatus::find($id);
    }

    public function createStatus(array $data)
    {
        return ReportStatus::create($data);
    }

    public function updateStatus($id, array $data)
    {
        $status = ReportStatus::find($id);
        $status->update($data);
        return $status;
    }

    public function deleteStatus($id)
    {
        $status = ReportStatus::find($id);
        $status->delete();
        return $status;
    }
}
