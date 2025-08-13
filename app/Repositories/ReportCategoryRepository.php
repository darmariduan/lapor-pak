<?php

namespace App\Repositories;

use App\Interfaces\ReportCategoryRepositoryInterface;
use App\Models\ReportCategory;
use App\Models\User;

class ReportCategoryRepository implements ReportCategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return ReportCategory::all();
    }

    public function getCategoryById(string $id)
    {
        return ReportCategory::find($id);
    }

    public function createCategory(array $data)
    {
        return ReportCategory::create($data);
    }

    public function updateCategory(string $id, array $data)
    {
        $category = ReportCategory::find($id);
        $category->update($data);
        return $category;
    }

    public function deleteCategory(string $id)
    {
        $category = ReportCategory::find($id);
        return $category->delete();
    }
}
