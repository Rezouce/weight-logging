<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Contracts\View\View;

class IndexWeightController
{
        public function __invoke(): View
        {
            $lastWeights = Weight::query()
                ->orderBy('date', 'DESC')
                ->limit(500)
                ->get();

            return view('add-weight', [
                'weights' => $lastWeights,
                'lastWeight' => $lastWeights->first() ?? Weight::createEmpty(),
            ]);
        }
}
