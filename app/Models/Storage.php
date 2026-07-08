<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $guarded = ['id'];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
