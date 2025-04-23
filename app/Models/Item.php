<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $fiallbe = ['name', 'description'];


    public function types()
    {
        return $this->hasMany(ItemType::class);
    }
}
