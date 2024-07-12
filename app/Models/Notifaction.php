<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifaction extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'user_id', // Owner of the pet
        'notifiable_id', // ID of the user who should be notified
        'message',
    ];
}

