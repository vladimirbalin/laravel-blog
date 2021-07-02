<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    public function creating(BlogPost $blogPost)
    {
        if ( !auth()->guard('admin')->check() ) {
            $this->setSlugFromTitle($blogPost);
        }
//      TODO::markdown
        $this->setHtmlFromRaw($blogPost);
        $this->setPublishedAtFromNow($blogPost);
        $this->setUserId($blogPost);
    }

    protected function setSlugFromTitle(BlogPost $blogPost)
    {
        $titleShouldBeConverted =
            $blogPost->title && !$blogPost->slug;

        if ($titleShouldBeConverted) {
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }

    /**
     * Handle the BlogPost "created" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
    }

    /**
     * Handle the BlogPost "updated" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    public function updating(BlogPost $blogPost)
    {
        $this->setPublishedAtFromNow($blogPost);
    }

    public function setPublishedAtFromNow(BlogPost $blogPost)
    {
        $needToSet = empty($blogPost->published_at) && $blogPost->is_published;
        if ($needToSet) {
            $blogPost->published_at = Carbon::now();
        }
    }

    public function setHtmlFromRaw(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    public function setUserId(BlogPost $blogPost)
    {
        if(auth()->check()){
            $blogPost->user_id = auth()->user()->id;
        }
    }

    /**
     * Handle the BlogPost "deleted" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "restored" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the BlogPost "force deleted" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
