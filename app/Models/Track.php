<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'album_id'
    ];
    public function albums()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
    public function views(){
        return $this->hasMany(View::class, 'track');
    }
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('title', 'like', '%' . $value . '%');
    }
    public function scopeOfArtist(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
    public function scopeOfAlbum(Builder $query, $value)
    {
        return $query->where('albums.name', 'like', '%' . $value . '%');
    }
    public function scopeOfStatus(Builder $query, $value)
    {
        return $query->where('public', '=', $value);
    }
}
