<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Petowner extends Authenticatable
{
    
    use HasFactory, Notifiable, HasApiTokens;


    public function adoptionRequests()
{
    return $this->hasMany(AdoptionRequest::class);
}
  
    protected $fillable = [
       'fullname',
       'phone_number',
       'date_of_birth',
       'gender',
       'email',
       'city',
       'password',
       'user_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
