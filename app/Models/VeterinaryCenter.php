<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeterinaryCenter extends Model
{
    use HasFactory;

    protected $table = 'veterinarycenters'; // Specify the table name

    protected $fillable = [
        'name',
        'phone_number',
        'rating',
        'city',
        'address',
    ];
}