<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'description',
        'city',
        'website',
        'facebook',
        'youtube',
        'twitter',
        'instagram',
        'telegram'
    ];

    public function relations(){
        return $this->hasMany(Relations::class, 'leader');
    }
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
}
