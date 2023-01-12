<?php

namespace App\Models;

use App\Events\BlogPostLikedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
 * @property int $status
 * @property string|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Models\BlogCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogComment[] $comments
 * @property-read int|null $comments_count
 * @property-read mixed $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $likedUsers
 * @property-read int|null $liked_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
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
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|BlogPost withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BlogPost withoutTrashed()
 * @mixin \Eloquent
 */
class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'excerpt',
        'content_raw',
        'content_html',
        'status',
        'user_id'
    ];

    protected $casts = [
        'category_id' => 'integer',
        'status' => 'integer',
        'user_id' => 'integer'
    ];

    protected $appends = [
        'likes_count'
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
            'blog_likes',
            'post_id',
            'user_id'
        );
    }

    /**
     * Like the post if it isn't, remove like otherwise.
     *
     * @return BlogPost
     * Updated model.
     */
    public function toggleLike(): BlogPost
    {
        if ($this->isLiked()) {
            return $this->dislike();
        } else {
            return $this->like();
        }
    }

    /**
     * Like the post by current authenticated user.
     *
     * @return BlogPost
     * Updated model with user, liked this post.
     */
    public function like(): BlogPost
    {
        $this->likedUsers()->attach(auth()->id());

        event(new BlogPostLikedEvent($this, auth()->user()));

        return $this->load('likedUsers');
    }

    public function dislike(): BlogPost
    {
        $this->likedUsers()->detach(auth()->id());

        return $this->load('likedUsers');
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likedUsers->count();
    }

    /**
     * Check if current authenticated user in the list of
     * users, who liked this post.
     *
     * @return bool
     */
    public function isLiked(): bool
    {
        return $this->likedUsers->contains(auth()->user());
    }

    public function isAuthor(): bool
    {
        return $this->user->id === auth()->id();
    }

    public function getAuthorName(): string
    {
        return $this->user->name;
    }

    public function whenPublished()
    {
        return Carbon::parse($this->published_at)->diffForHumans();
    }

    public function limitedContent($limit)
    {
        return Str::limit($this->content_html, $limit);
    }

    /**
     * Returns shortened published_at field string
     * if post has it, null if not.
     *
     * @return string|null
     */
    public function getPublishedAtShortened(): string|null
    {
        if (! $this->published_at) {
            return null;
        }

        return Carbon
            ::parse($this->published_at)
            ->format('d M H:i');
    }

    public function getCreatedAtShortened(): string
    {
        return Carbon::parse($this->created_at)->format('d M H:i');
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isNotPublished(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function publish()
    {
        if ($this->isNotPublished()) {
            $this->status = self::STATUS_PUBLISHED;
            $this->updatePublishedAt();
        }
    }

    public function updatePublishedAt()
    {
        if (!$this->published_at) {
            $this->published_at = now();
        }
    }
}
