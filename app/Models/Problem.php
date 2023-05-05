<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = ['categorie', 'autre', 'demande_id'];

    public function demande()
    {
        return $this->belongsTo('App\Demande');
    }
    public function interventions()
{
    return $this->hasMany('App\Intervention');
}
public function options()
{
    return $this->hasMany('App\Option');
}
public function diagnostics()
{
    return $this->hasMany('App\Diagnostic');
}
}
