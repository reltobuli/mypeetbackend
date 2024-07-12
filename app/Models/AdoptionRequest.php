<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    
        use HasFactory;
    
        protected $fillable = [
            'user_id',
            'pet_id',
            'message',
        ];
    
        // Other model methods
    
    
    //protected static function boot()
   // {
     //   parent::boot();
       // static::creating(function ($model) {
           // $model->id = (string) Str::uuid();
       // });
    //}

    

 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }


public function requestedBy()
{
    return $this->belongsTo(Petowner::class, 'requested_by');
}
}

