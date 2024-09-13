<?php

namespace Tests\Unit;

use App\Models\Mood;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MoodTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_moods_for_a_whole_month(): void
    {
        Carbon::setTestNow(new Carbon('2024-09-15'));

        $moods = Mood::getMonthMoods(1);

        $this->assertEquals('August', $moods->getMonthName());
        $this->assertCount(31, $moods);
        foreach ($moods as $i => $mood) {
            $this->assertEquals(
                (new Carbon('2024-08-01'))->addDays($i)->toDateString(),
                $mood->date->toDateString()
            );
        }
    }

    public function test_when_returning_the_moods_for_a_whole_month_it_uses_empty_moods_when_none_were_registered_in_database_for_the_day(): void
    {
        Carbon::setTestNow(new Carbon('2024-09-15'));

        Mood::factory()->date('2024-08-10')->value(1)->create();
        Mood::factory()->date('2024-08-12')->value(2)->create();
        Mood::factory()->date('2024-08-14')->value(3)->create();

        $moods = Mood::getMonthMoods(1);

        $this->assertEquals(0, $moods->getMoodForDay('9')->value);
        $this->assertEquals(1, $moods->getMoodForDay('10')->value);
        $this->assertEquals(0, $moods->getMoodForDay('11')->value);
        $this->assertEquals(2, $moods->getMoodForDay('12')->value);
        $this->assertEquals(0, $moods->getMoodForDay('13')->value);
        $this->assertEquals(3, $moods->getMoodForDay('14')->value);
        $this->assertEquals(0, $moods->getMoodForDay('15')->value);
    }

    public function test_it_returns_the_last_months_moods(): void
    {
        Carbon::setTestNow(new Carbon('2024-09-15'));

        $monthsMoods = Mood::getMoodsGroupByMonth();

        $this->assertCount(13, $monthsMoods);
        $this->assertEquals('September', $monthsMoods[0]->getMonthName());
        $this->assertEquals('October', $monthsMoods[1]->getMonthName());
        $this->assertEquals('November', $monthsMoods[2]->getMonthName());
        $this->assertEquals('December', $monthsMoods[3]->getMonthName());
        $this->assertEquals('January', $monthsMoods[4]->getMonthName());
        $this->assertEquals('February', $monthsMoods[5]->getMonthName());
        $this->assertEquals('March', $monthsMoods[6]->getMonthName());
        $this->assertEquals('April', $monthsMoods[7]->getMonthName());
        $this->assertEquals('May', $monthsMoods[8]->getMonthName());
        $this->assertEquals('June', $monthsMoods[9]->getMonthName());
        $this->assertEquals('July', $monthsMoods[10]->getMonthName());
        $this->assertEquals('August', $monthsMoods[11]->getMonthName());
        $this->assertEquals('September', $monthsMoods[12]->getMonthName());
    }
}
