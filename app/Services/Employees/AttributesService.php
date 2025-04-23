<?php

namespace App\Services\Employees;

use App\Interfaces\AttributesRepositoryInterface;

class AttributesService
{
    protected $attributesRepository;

    public function __construct(AttributesRepositoryInterface $attributesRepository)
    {
        $this->attributesRepository = $attributesRepository;
    }

    public function getAllAttributes()
    {
        return $this->attributesRepository->getAll();
    }

    public function getAttributeById(int $id)
    {
        return $this->attributesRepository->findById($id);
    }

    public function createAttribute(array $data)
    {
        return $this->attributesRepository->create($data);
    }

    public function updateAttribute(int $id, array $data)
    {
        return $this->attributesRepository->update($id, $data);
    }

    public function deleteAttribute(int $id)
    {
        return $this->attributesRepository->delete($id);
    }
}
