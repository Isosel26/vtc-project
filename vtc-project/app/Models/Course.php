<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'chauffeur_id',
        'departure', 'destination',
        'scheduled_at', 'status'
    ];

    // La course appartient à un client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // La course peut être liée à un chauffeur (lorsqu'elle est acceptée)
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}
