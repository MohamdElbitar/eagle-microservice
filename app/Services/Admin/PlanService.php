<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\PlanRepositoryInterface;

class PlanService
{
    protected $planRepository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function getAllPlans()
    {
        return $this->planRepository->getAll();
    }

    public function getPlanById($id)
    {
        return $this->planRepository->getById($id);
    }

    public function createPlan(array $data)
    {
        return $this->planRepository->create($data);
    }

    public function updatePlan($id, array $data)
    {
        return $this->planRepository->update($id, $data);
    }

    public function deletePlan($id)
    {
        return $this->planRepository->delete($id);
    }
}
