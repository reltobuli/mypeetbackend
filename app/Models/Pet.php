<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'picture',
        'name',
        'type',
        'gender',
        'age',
        'color',
        'address',
        'adoption_status',
    ];

    // Constants for adoption status
    const ADOPTION_PENDING = 'pending';
    const ADOPTION_AVAILABLE = 'available';
    const ADOPTION_ADOPTED = 'adopted';

    // Relationship with the Petowner model
    public function owner()
    {
        return $this->belongsTo(Petowner::class, 'user_id');
    }
    public function petowner()
    {
        return $this->belongsTo(Petowner::class);
    }
    // Example method: Scope to retrieve pets with a specific adoption status
    public function scopeByAdoptionStatus($query, $status)
    {
        return $query->where('adoption_status', $status);
    }
    public function adoptionRequests()
{
    return $this->hasMany(AdoptionRequest::class);
}
}

    
