<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogUsersToFollowedUsers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'user_id',
        'followed_user_id'
    ];
}
