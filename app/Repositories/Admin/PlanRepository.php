<?php

namespace App\Repositories\Admin;


use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Models\Plan;

class PlanRepository implements PlanRepositoryInterface
{
    public function getAll()
    {
        return Plan::with('businessApplications','prices.currency')->get();
    }

    public function getById($id)
    {
        return Plan::with('businessApplications','prices.currency')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Plan::create($data);
    }

    public function update($id, array $data)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($data);
        return $plan;
    }

    public function delete($id)
    {
        $plan = Plan::findOrFail($id);
        return $plan->delete();
    }
}
