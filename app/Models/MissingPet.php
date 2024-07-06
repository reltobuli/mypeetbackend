<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissingPet extends Model
{
    protected $table = 'missingpets'; // Specify the table name

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
  
    ];
}
