<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $fillable = [
        'name', 'slug', 'content'
    ];
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%')->orWhere('content', 'like', '%' . $value . '%');
    }
}
