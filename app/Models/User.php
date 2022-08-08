<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogPost[] $posts
 * @property-read int|null $posts_count
 * @property int $is_admin
 * @property string|null $phone
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followedByUsers
 * @property-read int|null $followed_by_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followedUsers
 * @property-read int|null $followed_users_count
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogPost[] $likedPosts
 * @property-read int|null $liked_posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function followedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'user_to_followed_user',
            'user_id',
            'followed_user_id'
        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'user_to_followed_user',
            'followed_user_id',
            'user_id'
        );
    }

    /**
     * Get posts, liked by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedPosts()
    {
        return $this->belongsToMany(
            BlogPost::class,
            'blog_post_likes',
            'user_id',
            'post_id'
        );
    }

    public function isAdmin()
    {
        return $this->is_admin == true;
    }

    public function followUser($user)
    {
        $id = $user instanceof User ? $user->{$user->primaryKey} : $user;
        $this->followedUsers()->attach(User::find($id));

        return $this;
    }

    public function unfollowUser($user)
    {
        $id = $user instanceof User ? $user->{$user->primaryKey} : $user;
        $this->followedUsers()->detach(User::find($id));

        return $this;
    }

    public function isFollow($user)
    {
        $id = $user instanceof User ?
            $user->{$user->primaryKey} :
            $user;
        $check = $this->followedUsers->keyBy('id')->has($id);

        return $check;
    }

    public function isNotFollow($user)
    {
        return !$this->isFollow($user);
    }
}
