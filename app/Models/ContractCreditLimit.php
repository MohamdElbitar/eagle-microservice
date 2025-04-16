<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractCreditLimit extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'credit_limit', 'type'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
