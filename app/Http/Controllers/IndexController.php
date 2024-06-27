<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Weight;
use Illuminate\Contracts\View\View;

class IndexController
{
    public function __invoke(): View
    {
        $lastWeights = Weight::query()
            ->orderBy('date', 'DESC')
            ->limit(500)
            ->get();

        return view('index', [
            'weights' => $lastWeights,
            'lastWeight' => $lastWeights->first() ?? Weight::createEmpty(),
            'moodsGroupByMonth' => Mood::getMoodsGroupByMonthFromLast365Days(),
        ]);
    }
}
