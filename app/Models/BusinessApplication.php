<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessApplication extends Model
{
    protected $fillable = ['name'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class)->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
