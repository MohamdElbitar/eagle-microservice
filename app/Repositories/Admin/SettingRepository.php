<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Models\TravelAgency;
use App\Models\User;

class SettingRepository implements SettingRepositoryInterface
{
    public function updateByAgencyId(int $agencyId, array $data): TravelAgency
    {
        $agency = TravelAgency::findOrFail($agencyId);
        $agency->update($data);
        return $agency;
    }
}
