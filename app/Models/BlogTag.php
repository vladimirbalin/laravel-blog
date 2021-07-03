<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlogTag
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
}
