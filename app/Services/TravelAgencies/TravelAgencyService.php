<?php

namespace App\Services\TravelAgencies;

use App\Models\TravelAgency;
use App\Models\User;
use App\Repositories\TravelAgencies\TravelAgencyRepository;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;


class TravelAgencyService
{
    public function __construct(protected TravelAgencyRepository $travelAgencyRepository) {

    }

    public function all(): Collection
    {
        return $this->travelAgencyRepository->all();
    }
    public function allPending(): Collection
    {
        return $this->travelAgencyRepository->allPending();
    }
    public function findById(int $id): TravelAgency
    {
        return $this->travelAgencyRepository->find($id);
    }

    public function show(int $id): TravelAgency
    {
        return $this->travelAgencyRepository->find($id);
    }

    public function viewRegister()
    {
        return $this->travelAgencyRepository->viewRegister();
    }
    public function create(array $data): TravelAgency
    {
        // Isolate user data
        $adminData = [
            'name'     => $data['admin_name'],
            'email'    => $data['admin_email'],
            'password' => bcrypt($data['admin_password']),
            'role'     => 'travel_agency_admin',
        ];

        unset($data['admin_name'], $data['admin_email'], $data['admin_password']);

        // $latest = TravelAgency::latest('id')->first();
        // $number = $latest ? ((int)str_replace('TA-', '', $latest->code)) + 1 : 1;
        // $code = 'TA-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        // $data['code'] = $code;

        $travelAgency = $this->travelAgencyRepository->create($data);

        $adminUser = new User($adminData);
        $adminUser->travel_agency_id = $travelAgency->id;
        $adminUser->save();

        $adminUser->assignRole('travel_agency_admin');
        $role = Role::where('name', 'travel_agency_admin')->first();
        $adminUser->givePermissionTo($role->permissions);

        return $travelAgency->load('users', 'plan.businessApplications.sections');
    }


    public function update(int $id, array $data): TravelAgency
    {
        return $this->travelAgencyRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->travelAgencyRepository->delete($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->travelAgencyRepository->forceDelete($id);
    }
    public function restore(int $id): bool
    {
        return $this->travelAgencyRepository->restore($id);
    }
}
