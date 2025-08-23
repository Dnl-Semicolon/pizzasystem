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

    public function daniel(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Daniel Tan',
            'email' => 'danielykt-pm23@student.tarc.edu.my',
            'password' => Hash::make('dWhy551177:'),
            'profile_photo_path' => 'assets/images/profile_photos/daniel.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function fongWenYi(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Fong Wen Yi',
            'email' => 'fongwy-pm23@student.tarc.edu.my',
            'password' => 'fongwy-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/fongWenYi.png',
            'email_verified_at' => null,
        ]);
    }

    public function fionTanXuanLing(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Fion Tan Xuan Ling',
            'email' => 'fiontxl-pm23@student.tarc.edu.my',
            'password' => 'fiontxl-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/fionTanXuanLing.png',
            'email_verified_at' => null,
        ]);
    }

    public function farhanIslamShafin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Farhan Islam Shafin',
            'email' => 'farhanis-pm23@student.tarc.edu.my',
            'password' => 'farhanis-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function limTziShe(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Lim Tzi She',
            'email' => 'limts-pm23@student.tarc.edu.my',
            'password' => 'limts-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function lawJunYan(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Law Jun Yan',
            'email' => 'lawjy-pm23@student.tarc.edu.my',
            'password' => 'lawjy-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/lawJunYan.png',
            'email_verified_at' => null,
        ]);
    }

    public function chengWinky(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Cheng Winky',
            'email' => 'chengw-pp22@student.tarc.edu.my',
            'password' => 'chengw-pp22', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function chanelOoiAnnJoa(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Chanel Ooi Ann Joa',
            'email' => 'chaneloaj-pp22@student.tarc.edu.my',
            'password' => 'chaneloaj-pp22', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function chooZhengYi(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Choo Zheng Yi',
            'email' => 'choozy-pm23@student.tarc.edu.my',
            'password' => 'choozy-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/chooZhengYi.png',
            'email_verified_at' => null,
        ]);
    }

    public function jivenesWaraan(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Jivenes Waraan',
            'email' => 'jiveneswsks-pm23@student.tarc.edu.my',
            'password' => 'jiveneswsks-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function rickyGohEuXie(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Ricky Goh Eu Xie',
            'email' => 'rickygex-pm23@student.tarc.edu.my',
            'password' => 'rickygex-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/rickyGohEuXie.png',
            'email_verified_at' => null,
        ]);
    }

    public function weeYiMing(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Wee Yi Ming',
            'email' => 'weeym-pm23@student.tarc.edu.my',
            'password' => 'weeym-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/weeYiMing.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function gooiKhaiYi(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Gooi Khai Yi',
            'email' => 'gooiky-wp22@student.tarc.edu.my',
            'password' => 'gooiky-wp22', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/gooiKhaiYi.png',
            'email_verified_at' => null,
        ]);
    }

    public function leongKaiBin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Leong Kai Bin',
            'email' => 'leongkb-pm23@student.tarc.edu.my',
            'password' => 'leongkb-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function liangZenYin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Liang Zen Yin',
            'email' => 'liangzy-pm23@student.tarc.edu.my',
            'password' => 'liangzy-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function tehJyyJiun(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Teh Jyy Jiun',
            'email' => 'tehjj-pm23@student.tarc.edu.my',
            'password' => 'tehjj-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function soonYenTeng(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Soon Yen Teng',
            'email' => 'soonyt-pm23@student.tarc.edu.my',
            'password' => 'soonyt-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function ongChinWei(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Ong Chin Wei',
            'email' => 'ongcw-pm23@student.tarc.edu.my',
            'password' => 'ongcw-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

    public function limJiaYing(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Lim Jia Ying',
            'email' => 'limjy-pm23@student.tarc.edu.my',
            'password' => 'limjy-pm23', // fixedPassword = unique part of email
            'profile_photo_path' => 'assets/images/profile_photos/default_pfp.jpg',
            'email_verified_at' => null,
        ]);
    }

}
