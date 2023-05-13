<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'repartition',
        'desinstallation',
        'reinstallation',
        'nouvelinstallation',
        'option',
        'sim',
        'car_id',
        'isValid',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function intervention()
    {
        return $this->hasOne(Intervention::class);
    }
}
