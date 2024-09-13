<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $weight
 */
class Weight extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'weight'];

    protected $casts = [
        'date' => 'datetime',
        'weight' => 'int',
    ];

    public function evolutionSince(Carbon $since): int
    {
        $sinceWeight = static::query()
            ->where('date', '<=', $since)
            ->orderBy('date', 'DESC')
            ->first() ?? static::createEmpty($this->weight);

        if ($since->diff($sinceWeight->date)->days === 0) {
            return $this->weight - $sinceWeight->weight;
        }

        $nextWeight = $sinceWeight->next();

        return ($nextWeight->weight - $sinceWeight->weight)
            / $nextWeight->date->diff($sinceWeight->date)->days
            * $since->diff($sinceWeight->date)->days;
    }

    public function previous(): static
    {
        /** @var Weight $previousWeight */
        $previousWeight = static::query()
            ->where('date', '<', $this->date)
            ->orderBy('date', 'DESC')
            ->first() ?? static::createEmpty($this->weight);

        return $previousWeight;
    }

    public function next(): static
    {
        /** @var Weight $nextWeight */
        $nextWeight = static::query()
            ->where('date', '>', $this->date)
            ->orderBy('date', 'ASC')
            ->first() ?? static::createEmpty($this->weight);

        return $nextWeight;
    }

    public static function createEmpty(int $weight = null): static
    {
        return new static([
            'date' => Carbon::now(),
            'weight' => $weight ?? 0,
        ]);
    }
}
