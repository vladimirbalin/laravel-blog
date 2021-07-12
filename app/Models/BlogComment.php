<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function isAuthor()
    {
        return $this->user->id === Auth::user()->id;
    }

    public function getAuthor()
    {
        return $this->isAuthor() ? 'You' : $this->user->name;
    }

    public function getStatusText()
    {
        return $this->isPublished() ? 'Published' : 'Draft';
    }

    public function getPublishedAtShortened()
    {
        return $this->isPublished() ?
            Carbon::parse($this->published_at)->format('d M H:m')
            : 'Not published';
    }

    public function getCreatedAtShortened()
    {
        return Carbon::parse($this->created_at)->format('d M H:m');
    }

    public function isPublished()
    {
        return $this->status === 1;
    }

}
