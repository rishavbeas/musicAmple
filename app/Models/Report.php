<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'track',
        'parent',
        'content',
        'type',
        'reason',
        'by'
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'by');
    }
    public function scopeSearchID(Builder $query, $value)
    {
        return $query->where('id', 'like', '%' . $value . '%');
    }
}
