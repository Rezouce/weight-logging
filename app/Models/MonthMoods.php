<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use IteratorAggregate;
use Traversable;

class MonthMoods implements IteratorAggregate
{
    private Carbon $firstDayOfMonth;
    private Collection $moods;

    public function __construct(int $monthNumber, Collection $registeredMoods)
    {
        $this->firstDayOfMonth = Carbon::now()
            ->month($monthNumber)
            ->firstOfMonth();

        $this->moods = collect();

        $day = clone $this->firstDayOfMonth;
        $lastDayDate = (clone $this->firstDayOfMonth)->lastOfMonth();

        while ($day->lte($lastDayDate)) {
            $mood = $registeredMoods->first(fn (Mood $mood) => $mood->date->eq($day));

            if (!$mood instanceof Mood) {
                $mood = new Mood(['date' => $day, 'value' => 0]);
            }

            $this->moods->push($mood);

            $day->addDay();
        }
    }

    public function getIterator(): Traversable
    {
        return $this->moods;
    }

    public function getMoodForDay(int $day): Mood
    {
        return $this->moods->firstOrFail(fn (Mood $mood) => $mood->date->day === $day);
    }

    public function getMonthName(): string
    {
        return $this->firstDayOfMonth->monthName;
    }
}
