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

    public static function getMoodsGroupByMonth(): Collection
    {
        $allMoods = collect();

        for ($i = 12; $i >= 0; --$i) {
            $allMoods->push(Mood::getMonthMoods($i));
        }

        return $allMoods;
    }

    public static function getMonthMoods(int $subMonth): MonthMoods
    {
        $firstDayDate = Carbon::now()->firstOfMonth()->subMonths($subMonth);
        $lastDayDate = (clone $firstDayDate)->lastOfMonth();

        $registeredMoods = static::query()
            ->orderBy('date', 'ASC')
            ->whereBetween('date', [$firstDayDate, $lastDayDate])
            ->get();

        return new MonthMoods($firstDayDate->year, $firstDayDate->month, $registeredMoods);
    }
}
