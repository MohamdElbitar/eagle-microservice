<?php

namespace App\Repositories\TravelAgencies;

use App\Models\TravelAgency;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\TravelAgency\TravelAgencyInterface;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;

class TravelAgencyRepository implements TravelAgencyInterface
{
    public function all(): Collection
    {
        return TravelAgency::with('users')->get();
    }
    public function allPending(): Collection
    {
        return TravelAgency::with('users')->where('status','pending')->get();
    }

    public function find(int $id): TravelAgency
    {
        return TravelAgency::with('users')->findOrFail($id);
    }
    public function viewRegister()
    {
        $palns=Plan::with('businessApplications.sections')->get();
        return $palns;
    }
    public function create(array $data): TravelAgency
    {
        $latest = TravelAgency::latest('id')->first();

        $number = $latest ? ((int)str_replace('TA-', '', $latest->code)) + 1 : 1;
        $code = 'TA-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $data['code'] = $code;

        return TravelAgency::create($data)->load('users','plan.businessApplications.sections');
    }


    public function update(int $id, array $data): TravelAgency
    {
        ($travelAgency = TravelAgency::findOrFail($id)->fill($data))
            ->save();

        return $travelAgency->load('users');
    }

    public function delete(int $id): bool
    {
        return TravelAgency::findOrFail($id)->delete();
    }

    public function forceDelete(int $id): bool
    {
        return TravelAgency::findOrFail($id)->forceDelete();
    }

    public function restore(int $id): bool
    {
        return TravelAgency::findOrFail($id)->restore();
    }
}
