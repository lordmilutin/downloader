<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    //

    public function getFileUrlAttribute($value) {
        return route('download', $value);
    }
}
