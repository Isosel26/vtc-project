<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    // Un client peut avoir plusieurs courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
