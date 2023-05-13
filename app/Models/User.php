<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['nom', 'prenom', 'email', 'password', 'tel', 'role'];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}

?>
