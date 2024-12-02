<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Production extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id'
    ];
    public function albums() {
        return $this->hasMany(Album::class);
    }

    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
}
