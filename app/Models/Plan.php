<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Define the relationship between Plan and BusinessApplication
    public function businessApplications()
    {
        return $this->belongsToMany(BusinessApplication::class)->withTimestamps();
    }

    public function prices()
    {
        return $this->hasMany(PlanPrice::class);
    }

}
