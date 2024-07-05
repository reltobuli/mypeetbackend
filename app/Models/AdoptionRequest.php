<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    use HasFactory;
    public function pet()
{
    return $this->belongsTo(Pet::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
