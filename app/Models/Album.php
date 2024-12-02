<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'public',
        'pid'
    ];
    public function productions()
    {
        return $this->belongsTo(Production::class, 'pid');
    }
    public function tracks(){
        return $this->hasMany(Track::class, 'album_id');
    }
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
    public function scopeOfStatus(Builder $query, $value)
    {
        return $query->where('public', '=', $value);
    }
}
