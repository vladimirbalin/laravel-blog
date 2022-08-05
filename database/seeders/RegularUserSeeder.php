<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegularUserSeeder extends Seeder
{
    private \Faker\Generator $faker;

    public function __construct(\Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regularUser = [
            'name' => $this->faker->name(),
            'email' => 'reg-user-1@user.com',
            'email_verified_at' => now(),
            'created_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];

        DB::table('users')->insert($regularUser);
    }
}
