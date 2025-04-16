<?php

namespace App\Interfaces\Admin;

interface SettingRepositoryInterface
{
    public function updateByAgencyId(int $agencyId, array $data): mixed;

}
