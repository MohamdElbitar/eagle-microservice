<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Department extends Model
{
    protected $fillable = ['name', 'description', 'email'];


    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function customerEmployees(): HasMany
    {
        return $this->hasMany(CustomerEmployee::class);
    }
}
