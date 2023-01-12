<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\BlogComment
 *
 * @property int $id
 * @property string $content
 * @property int $status
 * @property int $post_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $published_at
 * @property-read mixed $author
 * @property-read \App\Models\BlogPost $post
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BlogCommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogComment whereUserId($value)
 * @mixin \Eloquent
 */
class BlogComment extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    protected $fillable = ['content', 'status', 'post_id', 'user_id'];

    protected $casts = [
        'status' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function isAuthor(): bool
    {
        return $this->user->id === auth()->user()->id;
    }

    public function getAuthorAttribute(): string
    {
        return $this->user->name;
    }

    /**
     * Returns shortened published_at field string
     * if comment has it, false if not.
     *
     * @return string|false
     */
    public function getPublishedAtShortened(): string|false
    {
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
