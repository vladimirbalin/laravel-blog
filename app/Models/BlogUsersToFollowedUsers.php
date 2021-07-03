<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlogUsersToFollowedUsers
 *
 * @property int $id
 * @property int $user_id
 * @property int $followed_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToFollowedUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToFollowedUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToFollowedUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToFollowedUsers whereFollowedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToFollowedUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToFollowedUsers whereUserId($value)
 * @mixin \Eloquent
 */
class BlogUsersToFollowedUsers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'user_id',
        'followed_user_id'
    ];
}
