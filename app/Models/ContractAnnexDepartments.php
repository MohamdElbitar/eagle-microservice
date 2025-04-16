<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ContractAnnexDepartments extends Model
{
    protected $guarded = [];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
