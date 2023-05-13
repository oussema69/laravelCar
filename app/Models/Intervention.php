<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'autre',
        'user_id',
        'reclamation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reclamation()
    {
        return $this->belongsTo(Reclamation::class);
    }
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
