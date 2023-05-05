<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['type', 'problem_id'];

    public function problem()
    {
        return $this->belongsTo('App\Problem');
    }
}