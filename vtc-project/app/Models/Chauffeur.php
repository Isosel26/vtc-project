<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Chauffeur extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    // Un chauffeur peut accepter plusieurs courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
