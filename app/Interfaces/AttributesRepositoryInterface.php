<?php

namespace App\Interfaces;


interface AttributesRepositoryInterface
{

    public function getAll();

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    //employee attributes

    public function storeAttributes(int $entityId, string $category, array $attributes);

}
