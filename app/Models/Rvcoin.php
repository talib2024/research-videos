<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rvcoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'rvcoinsrewardtype_id',
        'received_rvcoins',
        'description',
    ];
}
