<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->createUsersWithSubscriptions(4, 2);
        $this->call(BlogRootCategorySeeder::class);
        BlogCategory::factory(9)->create();
        $this->createBlogPostsWithRandomNumberOfLikedUsers(100);
        BlogTag::factory(5)->create();
        BlogComment::factory(200)->create();
    }

    public function createBlogPostsWithRandomNumberOfLikedUsers($numberOfPosts): void
    {
        BlogPost::factory($numberOfPosts)->create()
            ->each(function ($post) {
                $range = range(1, rand(1, User::all()->last()->id));
                foreach ($range as $userId) {
                    $post->likedUsers()->attach($userId);
                }
            });
    }

    public function createUsersWithSubscriptions($numberOfUsers, $numberOfSubscriptions): void
    {
        if ($numberOfSubscriptions > User::all()->count() - 1) {
            throw new InvalidParameterException(
                'Number of subscriptions must be less than number of all users');
        }

        User::factory($numberOfUsers)->create()
            ->each(function ($user) use ($numberOfSubscriptions) {
                $subscriptions = User::all()->except($user->id)->random($numberOfSubscriptions);
                foreach ($subscriptions as $subscribedUser) {
                    $user->followedUsers()->attach($subscribedUser->id);
                }
            });
    }
}
