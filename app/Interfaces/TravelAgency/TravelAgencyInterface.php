<?php

namespace App\Interfaces\TravelAgency;

use App\Interfaces\Admin\SoftDeleteInterface;
use App\Models\TravelAgency;
use Illuminate\Database\Eloquent\Collection;


interface TravelAgencyInterface extends SoftDeleteInterface
{
    public function all(): Collection;
    public function find(int $id): TravelAgency;
    public function create(array $data): TravelAgency;
    public function update(int $id, array $data): TravelAgency;
    public function delete(int $id): bool;

}
