<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relations extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'leader',
        'subscriber',
        'type'
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'subscriber');
    }
    public function artists()
    {
        return $this->belongsTo(Artist::class, 'leader');
    }
}
