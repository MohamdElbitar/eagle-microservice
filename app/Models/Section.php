<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory ,SoftDeletes;

    protected $guarded = [];

    // Define the relationship between Section and Plan
    public function businessApplication()
    {
        return $this->belongsTo(BusinessApplication::class);
    }

}
