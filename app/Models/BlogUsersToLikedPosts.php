<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlogUsersToLikedPosts
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @method static \Database\Factories\BlogUsersToLikedPostsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToLikedPosts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToLikedPosts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToLikedPosts query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToLikedPosts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToLikedPosts wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogUsersToLikedPosts whereUserId($value)
 * @mixin \Eloquent
 */
class BlogUsersToLikedPosts extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['post_id', 'user_id'];
}
