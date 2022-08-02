<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
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
        $this->createUsersWithSubscriptions(5, 5);
        $this->call(BlogRootCategorySeeder::class);
        BlogCategory::factory(4)->create();
        $this->createBlogPostsWithRandomNumberOfLikedUsers(random_int(50, 200));
        BlogTag::factory(5)->create();
        BlogComment::factory(random_int(100, 300))->create();
    }

    public function createBlogPostsWithRandomNumberOfLikedUsers($numberOfPosts): void
    {
        BlogPost::factory($numberOfPosts)
            ->create()
            ->each(function ($post) {
                $usersCount = User::count();
                $likedUserIds = User::all()->random(rand(0, $usersCount))->pluck('id')->toArray();
                $likedUserIds = Arr::where($likedUserIds, function ($value) use ($post) {
                    return $value !== $post->user_id;
                });
                $post->likedUsers()->attach($likedUserIds);
            });
    }

    public function createUsersWithSubscriptions($numberOfUsers, $numberOfSubscriptionsEach): void
    {
        if ($numberOfSubscriptionsEach > $numberOfUsers) {
            throw new InvalidParameterException(
                'Number of subscriptions must be less than number of users provided');
        }

        User::factory($numberOfUsers)
            ->create()
            ->each(function ($user) use ($numberOfSubscriptionsEach) {
                $subscriptions = User::all()->except($user->id)->random($numberOfSubscriptionsEach);

                foreach ($subscriptions as $subscribedUser) {
                    $user->followedUsers()->attach($subscribedUser->id);
                }
            });
    }
}
