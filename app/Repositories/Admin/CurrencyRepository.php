<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\CurrencyRepositoryInterface;
use App\Models\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::all();
    }

    public function find($id)
    {
        return Currency::findOrFail($id);
    }

    public function create(array $data)
    {
        return Currency::create($data);
    }

    public function update($id, array $data)
    {
        $currency = $this->find($id);
        $currency->update($data);
        return $currency;
    }

    public function delete($id)
    {
        $currency = $this->find($id);
        return $currency->delete();
    }
}
