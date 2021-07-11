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

    protected $fillable = ['content', 'status', 'post_id', 'user_id'];
    public $statuses = [0 => 'Draft', 1 => 'Draft1', 2 => 'Draft2', 3 => 'Published'];

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

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return 'Draft';
            case 1:
                return 'Draft1';
            case 2:
                return 'Draft2';
            case 3:
                return 'Published';
            default:
                return 'Bad status';
        }
    }
    public function getPublishedAtShortened()
    {
        if($this->published_at){
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
