<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
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
     * if comment has it, null if not.
     *
     * @return string|null
     */
    public function getPublishedAtShortened(): string|null
    {
        if ($this->publishedAtIsNull()) {
            return null;
        }

        return Carbon
            ::parse($this->published_at)
            ->format('d M H:i');
    }

    /**
     * @return string|null
     */
    public function getCreatedAtShortened(): string|null
    {
        if (!$this->created_at) {
            return null;
        }
        return Carbon
            ::parse($this->created_at)
            ->format('d M H:i');
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isNotPublished(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function publish(): void
    {
        $this->status = self::STATUS_PUBLISHED;
        $this->setPublishedAtNow();
    }

    public function setPublishedAtNow(): void
    {
        $this->published_at = now();
    }

    public function neverPublishedBefore(): bool
    {
        return $this->publishedAtIsNull();
    }

    public function publishedAtIsNull(): bool
    {
        return $this->published_at === null;
    }
}
