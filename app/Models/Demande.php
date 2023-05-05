<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = ['type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function problem()
{
    return $this->hasOne('App\Problem');
}
}
