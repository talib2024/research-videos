<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'editorrole_id',
        'authortypes_id',
        'majorcategory_id',
        'subcategory_id',
        'highest_priority',
        'visible_status',
        'account_deletion_request',
        'account_deletion_request_date',
        'account_deleted_by',
        'account_deletion_date',
        'wallet_id',
        'total_rv_coins',
        'user_description',
    ];
}
