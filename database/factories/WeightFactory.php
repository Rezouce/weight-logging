<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weight>
 */
class WeightFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'weight' => fake()->numberBetween(5000, 10000),
        ];
    }

    public function date(Carbon|string $date): static
    {
        return $this->state(fn () => ['date' => $date]);
    }

    public function weight(int $weight): static
    {
        return $this->state(fn () => ['weight' => $weight]);
    }
}
