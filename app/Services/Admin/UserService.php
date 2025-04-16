<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUserWithRole(array $data, string $roleName)
    {
        $travelAgencyId = auth()->user()->travel_agency_id;

        // Prepare user data
        $userData = [
            'name' => $data['name'] ?? $data['first_name'] . ' ' . $data['last_name'],
            'email' => $roleName === 'employee' ? $data['work_email'] : $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $roleName,
            'travel_agency_id' => $travelAgencyId,
        ];

        // Create the user
        $user = $this->userRepository->create($userData);

        // Assign role and permissions
        $this->assignRoleAndPermissions($user, $roleName);

        return $user;
    }

    /**
     * Assign a role and its permissions to a user.
     *
     * @param $user
     * @param string $roleName
     * @return void
     */
    protected function assignRoleAndPermissions($user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $user->assignRole($role);
            $user->givePermissionTo($role->permissions);
        }
    }

    public function delete(int $id)
    {
        $this->userRepository
                ->delete($id);
    }
}
