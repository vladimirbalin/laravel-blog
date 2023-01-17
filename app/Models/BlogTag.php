<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\BlogTag
 *
 * @property int $id
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogPost[] $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\BlogTagFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class BlogTag extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogPost::class,
            'blog_tags_to_posts',
            'tag_id',
            'post_id'
        );
    }

    public function getCreatedAtShortened(): string|null
    {
        if (! $this->created_at){
            return null;
        }

        return Carbon
            ::parse($this->created_at)
            ->format('M d Y H:m');
    }

    public function getUpdatedAtShortened(): string|null
    {
        if (! $this->updated_at){
            return null;
        }
        return Carbon
            ::parse($this->updated_at)
            ->format('M d Y H:m');
    }
}
