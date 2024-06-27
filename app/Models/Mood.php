<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Carbon $date
 * @property int $value
 */
class Mood extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'value'];

    protected $casts = [
        'date' => 'datetime',
        'value' => 'int',
    ];

    public static function getMoodsGroupByMonthFromLast365Days(): Collection
    {
        $registeredMoods = static::query()
            ->orderBy('date', 'DESC')
            ->limit(365)
            ->get();

        $allMoods = collect();

        $today = Carbon::today();
        $day = Carbon::today()->subYear();

        while ($day->lt($today)) {
            $mood = $registeredMoods->first(fn (Mood $mood) => $mood->date->eq($day));

            if (!$mood instanceof Mood) {
                $mood = new Mood(['date' => $day, 'value' => 0]);
            }

            $allMoods->push($mood);

            $day->addDay();
        }

        return $allMoods->groupBy((fn (Mood $mood) => $mood->date->year . '-' . $mood->date->month));
    }
}
