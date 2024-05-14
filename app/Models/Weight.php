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

        return $this->weight - $sinceWeight->weight;
    }

    public static function createEmpty(int $weight = null): static
    {
        return new static([
            'date' => Carbon::now(),
            'weight' => $weight ?? 0,
        ]);
    }
}
