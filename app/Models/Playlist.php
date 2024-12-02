<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'public',
        'by',
        'image'
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'by');
    }
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
    public function scopeSearchDescription(Builder $query, $value)
    {
        return $query->where('description', 'like', '%' . $value . '%');
    }
    public function scopeOfStatus(Builder $query, $value)
    {
        return $query->where('public', '=', $value);
    }
}
