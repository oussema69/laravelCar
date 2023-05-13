<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['matricule', 'model','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class);
    }
}
