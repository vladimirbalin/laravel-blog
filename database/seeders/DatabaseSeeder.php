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
     * @throws \Exception
     */
    public function run()
    {
        $this->createUsers();
        $this->createCategories();
        $this->createPostsWithRandomLikes(random_int(50, 200));
        $this->createComments();
        $this->createTags();
    }

    public function createPostsWithRandomLikes($numberOfPosts): void
    {
        BlogPost::factory($numberOfPosts)
            ->createQuietly()
            ->each(function ($post) {
                $usersCount = User::count();
                $likedUserIds = User
                    ::all()
                    ->random(rand(0, $usersCount))
                    ->pluck('id')
                    ->toArray();
                $likedUserIds = Arr::where($likedUserIds, function ($value) use ($post) {
                    return $value !== $post->user_id;
                });
                $post
                    ->likedUsers()
                    ->attach($likedUserIds);
            });
    }

    public function createUsersWithSubscriptions(
        $numberOfUsers,
        $numberOfSubscriptionsEach
    ): void
    {
        if ($numberOfSubscriptionsEach > $numberOfUsers) {
            throw new InvalidParameterException(
                'Number of subscriptions must be less than number of users provided');
        }

        User::factory($numberOfUsers)
            ->create()
            ->each(function ($user) use ($numberOfSubscriptionsEach) {
                $subscriptions = User
                    ::all()
                    ->except($user->id)
                    ->random($numberOfSubscriptionsEach);

                foreach ($subscriptions as $subscribedUser) {
                    $user
                        ->followedUsers()
                        ->attach($subscribedUser->id);
                }
            });
    }

    public function createCategories()
    {
        $this->call(BlogRootCategorySeeder::class);
        BlogCategory::factory(4)->create();
    }

    public function createUsers()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(RegularUserSeeder::class);
        $this->createUsersWithSubscriptions(5, 5);

    }

    public function createTags()
    {
        BlogTag::factory(5)->create();
    }

    public function createComments()
    {
        BlogComment::factory(random_int(100, 300))->createQuietly();
    }
}
