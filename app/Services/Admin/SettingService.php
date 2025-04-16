<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Repositories\Admin\SettingRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SettingService
{
    protected SettingRepository $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function updateSettings(int $travelAgencyId, array $data): mixed
    {
        return $this->settingRepository->updateByAgencyId($travelAgencyId, $data);
    }
}
