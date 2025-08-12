<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Interfaces\ResidentRepositoryInterface;
use Illuminate\Contracts\Cache\Store;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class ResidentController extends Controller
{
    private $residentRepository;

    public function __construct(ResidentRepositoryInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = $this->residentRepository->getAllResidents();
        return view('pages.admin.residents.index', compact('residents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.residents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResidentRequest $request)
    {
        $data = $request->validated();

        $data['avatar'] = $data['avatar'] ? $data['avatar']->store('assets/avatars', 'public') : null;

        $this->residentRepository->createResident($data);
        Swal::toast('Data berhasil ditambahkan.', 'success')->timerProgressBar();

        return redirect()->route('admin.residents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resident = $this->residentRepository->getResidentById($id);
        return view('pages.admin.residents.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $resident = $this->residentRepository->getResidentById($id);
        return view('pages.admin.residents.edit', compact('resident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResidentRequest $request, string $id)
    {
        $data = $request->validated();

        $data['avatar'] = $data['avatar'] ? $data['avatar']->store('assets/avatars', 'public') : null;

        $this->residentRepository->updateResident($id, $data);
        Swal::toast('Data berhasil diupdate.', 'success')->timerProgressBar();

        return redirect()->route('admin.residents.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->residentRepository->deleteResident($id);

        Swal::toast('Data berhasil dihapus.', 'success')->timerProgressBar();

        return redirect()->route('admin.residents.index');
    }
}
