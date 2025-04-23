<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\CurrencyRepositoryInterface;

class CurrencyService
{
    protected $currencyRepo;

    public function __construct(CurrencyRepositoryInterface $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

    public function getAll()
    {
        return $this->currencyRepo->all();
    }

    public function getById($id)
    {
        return $this->currencyRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->currencyRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->currencyRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->currencyRepo->delete($id);
    }
}
