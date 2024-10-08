<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Countable;
use Illuminate\Support\Collection;
use IteratorAggregate;
use Traversable;

class MonthMoods implements IteratorAggregate, Countable
{
    private Carbon $firstDayOfMonth;
    private Collection $moods;

    public function __construct(int $year, int $month, Collection $registeredMoods)
    {
        $this->firstDayOfMonth = Carbon::now()
            ->year($year)
            ->month($month)
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

    public function count(): int
    {
        return $this->moods->count();
    }
}
