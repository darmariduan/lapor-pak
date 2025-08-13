<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;
use App\Repositories\ReportCategoryRepository;
use RealRashid\SweetAlert\Facades\Alert as Swal;
use App\Http\Requests\StoreReportCategoryRequest;
use App\Http\Requests\UpdateReportCategoryRequest;
use App\Interfaces\ReportCategoryRepositoryInterface;

class ReportCategoryController extends Controller
{

    private ReportCategoryRepositoryInterface $reportCategoryRepository;

    public function __construct(ReportCategoryRepositoryInterface $reportCategoryRepository)
    {
        $this->reportCategoryRepository = $reportCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->reportCategoryRepository->getAllCategories();
        return view('pages.admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportCategoryRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('assets/report-categories/image', 'public');
        $this->reportCategoryRepository->createCategory($data);
        Swal::toast('success', 'Category created successfully.')->timerProgressBar();
        return redirect()->route('admin.report-categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->reportCategoryRepository->getCategoryById($id);
        return view('pages.admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->reportCategoryRepository->getCategoryById($id);
        return view('pages.admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportCategoryRequest $request, string $id)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/report-categories/image', 'public');
        }
        $this->reportCategoryRepository->updateCategory($id, $data);
        Swal::toast('success', 'Category updated successfully.')->timerProgressBar();
        return redirect()->route('admin.report-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->reportCategoryRepository->deleteCategory($id);
        Swal::toast('success', 'Category deleted successfully.')->timerProgressBar();
        return redirect()->route('admin.report-categories.index');
    }
}
