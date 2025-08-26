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

        $user->assignRole('resident');

        return $user->resident()->create($data);
    }

    public function updateResident(int $id, array $data)
    {
        $resident = $this->getResidentById($id);

        $resident->user->update([
            'name' => $data['name'],
            'password' => isset($data['password']) ? bcrypt($data['password']) : $resident->user->password,
        ]);

        $resident->update($data);

        return $resident;
    }

    public function deleteResident(int $id)
    {
        $resident = $this->getResidentById($id);

        if ($resident) {
            $resident->user->delete();
            return $resident->delete();
        }

        return false;
    }
}
