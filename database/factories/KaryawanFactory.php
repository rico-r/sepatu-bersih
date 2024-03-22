<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Karyawan>
 */
class KaryawanFactory extends Factory
{

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'username' => fake()->userName(),
            'password' => static::$password ??= Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ];
    }
}
