<?php

namespace Tests\Unit;

use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeightTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_previous_recorded_weight(): void
    {
        Weight::factory()->date(('2024-09-01'))->create();
        $previous = Weight::factory()->date(('2024-09-10'))->create();
        $weight = Weight::factory()->date(('2024-09-14'))->create();
        Weight::factory()->date(('2024-09-20'))->create();

        $this->assertEquals($previous->id, $weight->previous()->id);
    }

    public function test_it_returns_the_next_recorded_weight(): void
    {
        Weight::factory()->date(('2024-09-01'))->create();
        $weight = Weight::factory()->date(('2024-09-10'))->create();
        $next = Weight::factory()->date(('2024-09-14'))->create();
        Weight::factory()->date(('2024-09-20'))->create();

        $this->assertEquals($next->id, $weight->next()->id);
    }

    public function test_it_returns_the_weight_evolution_between_the_given_weight_and_the_one_from_the_given_date(): void
    {
        Weight::factory()->date(('2024-09-10'))->weight(8000)->create();
        $weight = Weight::factory()->date(('2024-09-14'))->weight(9000)->create();

        $this->assertEquals(1000, $weight->evolutionSince(new Carbon('2024-09-10')));
    }

    public function test_it_returns_a_calculated_weight_evolution_between_the_given_weight_and_the_one_from_the_given_date_when_there_isnt_a_weight_recorded_for_the_date(): void
    {
        Weight::factory()->date(('2024-09-10'))->weight(8000)->create();
        $weight = Weight::factory()->date(('2024-09-14'))->weight(9000)->create();

        $this->assertEquals(500, $weight->evolutionSince(new Carbon('2024-09-12')));
    }

    public function test_it_returns_the_weight_evolution_even_when_the_database_is_empty(): void
    {
        $weight = Weight::factory()->date(('2024-09-14'))->weight(9000)->make();

        $this->assertEquals(0, $weight->evolutionSince(new Carbon('2024-09-12')));
    }
}
