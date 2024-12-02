<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
     // Define the hidden attributes
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'website',
        'ip',
        'image',
        'cover',
        'type',
        'description',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'telegram',
        'country',
        'city',
        'website',
        'private'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
}
