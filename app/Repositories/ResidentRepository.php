<?php

namespace App\Repositories;

use App\Models\Resident;
use App\Interfaces\ResidentRepositoryInterface;
use App\Models\User;

class ResidentRepository implements ResidentRepositoryInterface
{
    public function getAllResidents()
    {
        return Resident::all();
    }

    public function getResidentById(int $id)
    {
        return Resident::find($id);
    }

    public function createResident(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return $user->resident()->create($data);
    }

    public function updateResident(int $id, array $data)
    {
        $resident = Resident::find($id);
        if ($resident) {
            $resident->update($data);
            return $resident;
        }
        return null;
    }

    public function deleteResident(int $id)
    {
        $resident = Resident::find($id);
        if ($resident) {
            $resident->delete();
            return true;
        }
        return false;
    }
}
