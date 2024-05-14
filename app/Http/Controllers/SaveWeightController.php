<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class SaveWeightController
{
        public function __invoke(): RedirectResponse
        {
            $date = new Carbon(request()->get('date'));

            $weight = Weight::firstOrNew(['date' => $date]);

            $weight->weight = request()->get('weight') * 100;

            $weight->save();

            return redirect()->route('index-weight');
        }
}
