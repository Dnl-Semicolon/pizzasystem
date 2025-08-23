<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'profile_photo_path' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Get array of friend data for seeding
     */
    public static function getFriendsData(): array
    {
        return [
            [
                'name' => 'Daniel Tan',
                'email' => 'danielykt-pm23@student.tarc.edu.my',
                'phone' => '01124120654',
                'password' => Hash::make('dWhy551177:'),
                'profile_photo_path' => 'assets/images/profile_photos/daniel-tan_1755324145.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Fong Wen Yi',
                'email' => 'fongwy-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('fongwy-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/fongWenYi.png',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Fion Tan Xuan Ling',
                'email' => 'fiontxl-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('fiontxl-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/fionTanXuanLing.png',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Farhan Islam Shafin',
                'email' => 'farhanis-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('farhanis-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Lim Tzi She',
                'email' => 'limts-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('limts-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Law Jun Yan',
                'email' => 'lawjy-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('lawjy-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/lawJunYan.png',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Cheng Winky',
                'email' => 'chengw-pp22@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('chengw-pp22'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Chanel Ooi Ann Joa',
                'email' => 'chaneloaj-pp22@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('chaneloaj-pp22'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Choo Zheng Yi',
                'email' => 'choozy-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('choozy-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/chooZhengYi.png',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Jivenes Waraan',
                'email' => 'jiveneswsks-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('jiveneswsks-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Ricky Goh Eu Xie',
                'email' => 'rickygex-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('rickygex-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/rickyGohEuXie.png',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Wee Yi Ming',
                'email' => 'weeym-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('weeym-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/weeYiMing.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Gooi Khai Yi',
                'email' => 'gooiky-wp22@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('gooiky-wp22'),
                'profile_photo_path' => 'assets/images/profile_photos/gooiKhaiYi.png',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Leong Kai Bin',
                'email' => 'leongkb-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('leongkb-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Liang Zen Yin',
                'email' => 'liangzy-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('liangzy-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Teh Jyy Jiun',
                'email' => 'tehjj-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('tehjj-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Soon Yen Teng',
                'email' => 'soonyt-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('soonyt-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Ong Chin Wei',
                'email' => 'ongcw-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('ongcw-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/ong-chin-wei_1755930146.jpg',
                'email_verified_at' => null,
            ],
            [
                'name' => 'Lim Jia Ying',
                'email' => 'limjy-pm23@student.tarc.edu.my',
                'phone' => fake()->unique()->phoneNumber(),
                'password' => Hash::make('limjy-pm23'),
                'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
                'email_verified_at' => null,
            ],
        ];
    }

}
