<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie',
        'type',
        'value',
        'intervention_id',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}
