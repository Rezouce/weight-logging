<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mood>
 */
class MoodFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'value' => fake()->numberBetween(0, 4),
        ];
    }

    public function date(Carbon|string $date): static
    {
        return $this->state(fn () => ['date' => $date]);
    }

    public function value(int $value): static
    {
        return $this->state(fn () => ['value' => $value]);
    }
}
