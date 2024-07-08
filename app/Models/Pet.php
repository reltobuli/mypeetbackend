<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture',
        'name',
        'type',
        'gender',
        'age',
        'color',
        'pet_id',
        'address',
        'qrcode',
        'is_missing',
       ' adoption_status',
       
    ];
    const ADOPTION_PENDING = 'pending';
    const ADOPTION_AVAILABLE = 'available';
    const ADOPTION_ADOPTED = 'adopted';
   
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    }
    
