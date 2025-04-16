<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['contract_number', 'subject', 'description', 'from_date', 'to_date', 'customer_id'];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function itemFees(): BelongsToMany
    {
        return $this->belongsToMany(ItemType::class, 'contract_fees')
                    ->withPivot(['contract_id', 'item_type_id', 'fees', 'value_type', 'currency']);
    }

    public function annex_departments(): HasMany
    {
        return $this->hasMany(ContractAnnexDepartments::class);
    }

    public function creditLimit()
    {
        return $this->hasOne(ContractCreditLimit::class);
    }

    public function attributes() {
        return $this->hasMany(AttributeValue::class, 'entity_id')->whereHas('attribute', function ($query) {
            $query->where('category', 'contract');
        });
    }
}
