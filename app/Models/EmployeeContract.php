<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeContract extends Model
{
    protected $guarded = [];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function attributes() {
        return $this->hasMany(AttributeValue::class, 'entity_id')->whereHas('attribute', function ($query) {
            $query->where('category', 'contract');
        });
    }
}
