<?php

namespace App\Services\Employees;

use App\Interfaces\AttributesRepositoryInterface;
use App\Interfaces\Employees\EmployeeContractRepositoryInterface;

class EmployeeContractService
{
    protected $contractRepository;
    protected $attributesRepository;

    public function __construct(
        EmployeeContractRepositoryInterface $contractRepository,
        AttributesRepositoryInterface $attributesRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->attributesRepository = $attributesRepository;
    }

    public function getAllContracts()
    {
        return $this->contractRepository->getAll();
    }

    public function getContractById(int $id)
    {
        return $this->contractRepository->findById($id);
    }

    public function createContract(array $data)
    {
        $attributes = $data['attributes'] ?? [];
        unset($data['attributes']);

        $contract = $this->contractRepository->create($data);

        if (!empty($attributes)) {
            $this->attributesRepository->storeAttributes($contract->id, 'contract',$attributes);
        }

        return $contract->load('attributes');
    }

    public function updateContract(int $id, array $data)
    {
        $attributes = $data['attributes'] ?? [];
        $newAttributes = $data['new_attributes'] ?? [];

        unset($data['attributes'], $data['new_attributes']);

        $contract = $this->contractRepository->update($id, $data);

        if (!$contract || !isset($contract->id)) {
            throw new \Exception("Failed to update contract or contract not found.");
        }

        if (!empty($attributes)) {
            $this->attributesRepository->storeAttributes($contract->id, 'contract', $attributes);
        }
        if (!empty($newAttributes)) {
                $this->attributesRepository->storeAttributes($contract->id, 'contract',$newAttributes);
        }

        return $contract->load('attributes');
    }



    public function deleteContract(int $id)
    {
        return $this->contractRepository->delete($id);
    }
}
