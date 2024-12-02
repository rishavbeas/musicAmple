<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function playlists(){
        return $this->hasMany(Playlist::class, 'by');
    }
    public function views(){
        return $this->hasMany(View::class, 'by');
    }
    public function reports(){
        return $this->hasMany(Report::class, 'by');
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'uid');
    }
    public function relations(){
        return $this->hasMany(Relations::class, 'leader');
    }
    public function scopeSearchUserName(Builder $query, $value)
    {
        return $query->where('username', 'like', '%' . $value . '%');
    }

    public function scopeSearchEmail(Builder $query, $value)
    {
        return $query->where('email', 'like', '%' . $value . '%');
    }

    public function scopeOfRole(Builder $query, $value)
    {
        return $query->where('role', '=', $value);
    }

    public function admin()
    {
        return $this->role == 1;
    }
}
