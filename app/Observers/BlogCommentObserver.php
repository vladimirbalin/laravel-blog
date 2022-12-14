<?php

namespace App\Observers;

use App\Models\BlogComment;

class BlogCommentObserver
{
    public function creating(BlogComment $blogComment)
    {
        $blogComment->publish();
    }
    /**
     * Handle the BlogComment "created" event.
     *
     * @param  \App\Models\BlogComment  $blogComment
     * @return void
     */
    public function created(BlogComment $blogComment)
    {
        //
    }

    /**
     * Handle the BlogComment "updated" event.
     *
     * @param  \App\Models\BlogComment  $blogComment
     * @return void
     */
    public function updated(BlogComment $blogComment)
    {
        //
    }

    /**
     * Handle the BlogComment "deleted" event.
     *
     * @param  \App\Models\BlogComment  $blogComment
     * @return void
     */
    public function deleted(BlogComment $blogComment)
    {
        //
    }

    /**
     * Handle the BlogComment "restored" event.
     *
     * @param  \App\Models\BlogComment  $blogComment
     * @return void
     */
    public function restored(BlogComment $blogComment)
    {
        //
    }

    /**
     * Handle the BlogComment "force deleted" event.
     *
     * @param  \App\Models\BlogComment  $blogComment
     * @return void
     */
    public function forceDeleted(BlogComment $blogComment)
    {
        //
    }
}
