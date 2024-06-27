<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Mood;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class SaveMoodController
{
    public function __invoke(): RedirectResponse
    {
        $date = new Carbon(request()->get('date'));

        $mood = Mood::firstOrNew(['date' => $date]);

        $mood->value = request()->get('mood');

        $mood->save();

        return redirect()->route('index');
    }
}
