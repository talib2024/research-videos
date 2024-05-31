<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlaterlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'videoupload_id',
        'type',
    ];
}
