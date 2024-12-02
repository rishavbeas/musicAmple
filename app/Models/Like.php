<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'by',
        'track'
    ];
    public function users(){
        return $this->belongsTo(User::class, 'by');
    }
}
