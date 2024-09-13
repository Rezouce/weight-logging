<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $weights = DB::table('weights')
            ->select('date', 'weight')
            ->orderBy('date')
            ->get();

        $weightsArray = $weights->toArray();
        $numEntries = count($weightsArray);
        $tolerance = 500;

        for ($i = 1; $i < $numEntries; $i++) {
            $weightsArray[$i]->diff = $weightsArray[$i]->weight - $weightsArray[$i-1]->weight;
        }

        $periods = [];
        $currentPeriod = null;
        $lowestWeight = 99999;

        for ($i = 1; $i < $numEntries; $i++) {
            if ($weightsArray[$i]->diff < 0 || $weightsArray[$i]->weight - $lowestWeight <= $tolerance) {
                if ($weightsArray[$i]->weight < $lowestWeight) {
                    $lowestWeight = $weightsArray[$i]->weight;
                }

                if ($currentPeriod === null) {
                    $currentPeriod = [
                        'start_date' => $weightsArray[$i-1]->date,
                        'end_date' => $weightsArray[$i]->date,
                        'total_drop' => $weightsArray[$i]->diff,
                        'starting_weight' => $weightsArray[$i]->weight,
                        'ending_weight' => $weightsArray[$i]->weight,
                        'duration' => 1,
                    ];
                } else {
                    $currentPeriod['end_date'] = $weightsArray[$i]->date;
                    $currentPeriod['total_drop'] += $weightsArray[$i]->diff;
                    $currentPeriod['ending_weight'] = $weightsArray[$i]->weight;
                    $currentPeriod['duration']++;
                }
            } else {
                if ($currentPeriod !== null) {
                    $periods[] = $currentPeriod;
                    $currentPeriod = null;
                }
            }
        }

        if ($currentPeriod !== null) {
            $periods[] = $currentPeriod;
        }

        $maxDropPeriod = collect($periods)
            ->sortBy('total_drop')
            ->first();

        echo "Période de la plus grande baisse : \n";
        echo sprintf("Du %s au %s (%s jours)", $maxDropPeriod['start_date'], $maxDropPeriod['end_date'], $maxDropPeriod['duration']) . "\n";
        echo sprintf("De %skg à %skg (%skg)", $maxDropPeriod['starting_weight'] / 100, $maxDropPeriod['ending_weight'] / 100, $maxDropPeriod['total_drop'] / 100) . "\n";
    }
}
