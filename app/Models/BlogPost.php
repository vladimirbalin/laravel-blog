<?php

namespace App\Models;

use App\Events\BlogPostLikedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\BlogPost
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string|null $excerpt
 * @property string $content_raw
 * @property string $content_html
 * @property int $is_published
 * @property string|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Database\Factories\BlogPostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost newQuery()
 * @method static \Illuminate\Database\Query\Builder|BlogPost onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereContentHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereContentRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|BlogPost withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BlogPost withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\BlogCategory $category
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $likedUsers
 * @property-read int|null $liked_users_count
 */
class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'excerpt',
        'content_raw',
        'content_html',
        'is_published',
        'user_id'
    ];

    protected $casts = [
        'category_id' => 'integer',
        'is_published' => 'boolean',
        'user_id' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_tags_to_posts',
            'post_id',
            'tag_id'
        );
    }

    public function likedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'blog_users_to_liked_posts',
            'post_id',
            'user_id'
        );
    }

    public function toggleLike()
    {
        if ($this->isLiked()) {
            $this->dislike();
        } else {
            $this->like();
        }
    }

    public function like()
    {
        BlogUsersToLikedPosts::create([
            'post_id' => $this->id,
            'user_id' => auth()->id()
        ]);

        event(new BlogPostLikedEvent($this, Auth::getUser()));
    }

    public function dislike()
    {
        BlogUsersToLikedPosts::where([
            'post_id' => $this->id,
            'user_id' => auth()->id()
        ])->delete();
    }

    public function getLikesCountAttribute()
    {
        return $this->likedUsers->count();
    }

    public function isLiked()
    {
        return $this->likedUsers->contains(Auth::user());
    }

    public function isAuthor()
    {
        return $this->user->id === Auth::user()->id;
    }

    public function getAuthorName()
    {
        return $this->isAuthor() ? 'You' : $this->user->name;
    }

    public function whenPublished()
    {
        return Carbon::parse($this->published_at)->diffForHumans();
    }

    public function limitedContent()
    {
        return \Illuminate\Support\Str::limit($this->content_html, 250);
    }

    public function getPublishedAtShortened()
    {
        if ($this->published_at) {
            return Carbon::parse($this->published_at)->format('d M H:m');
        } else {
            return 'Not published yet';
        }
    }

    public function getCreatedAtShortened()
    {
        return Carbon::parse($this->created_at)->format('d M H:m');
    }

}
