<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Attributes\Customer\CustomerAttributeValue;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    // protected $guarded = [];
    protected $fillable = [
        'name', 'type','phone', 'country', 'city', 'zip', 'state', 'address', 'website',
        'status', 'currency', 'balance', 'blalance_date','created_by','user_id',
        'group_id','lead_source_id','salesperson_id','cr', 'vat_id', 'license'

    ];
    protected $hidden = ['pivot'];


    public function attributes() {
        return $this->hasMany(AttributeValue::class, 'entity_id')->whereHas('attribute', function ($query) {
            $query->where('category', 'customer');
        });
    }
    public function employees()
    {
        return $this->belongsToMany(User::class, 'customer_employees');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'customer_id')
                    ->with('itemFees');
    }

    public function itemMarkups(): BelongsToMany
    {
        return $this->belongsToMany(ItemType::class, 'customer_markups')
                    ->withPivot(['customer_id', 'item_type_id', 'markup', 'value_type', 'currency']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'group_id');
    }

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    public function salesperson()
    {
        return $this->belongsTo(Employee::class, 'salesperson');
    }

}
