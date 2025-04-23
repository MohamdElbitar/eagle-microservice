<?php

namespace App\Services;

use App\Repositories\AttributesRepository;
use Illuminate\Http\Request;

class AttributeService
{
    protected AttributesRepository $attributeRepository;


    public function __construct(Request $request)
    {
        $this->attributeRepository = new AttributesRepository($request->post('form_type'));
    }

    public function getAllAttributes()
    {
        return $this->attributeRepository->getAll();
    }

    public function getAttributeById(int $id)
    {
        return $this->attributeRepository->findById($id);
    }

    public function createAttribute(array $data)
    {
        return $this->attributeRepository->create($data);
    }

    public function updateAttribute(int $id, array $data)
    {
        return $this->attributeRepository->update($id, $data);
    }

    public function deleteAttribute(int $id)
    {
        return $this->attributeRepository->delete($id);
    }
}
