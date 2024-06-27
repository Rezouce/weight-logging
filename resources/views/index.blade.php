@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Logs</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.bunny.net/css?open-sans:300,400,700" rel="stylesheet" />

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            @apply text-zinc-700;
        }
    </style>
</head>
<body class="antialiased">
<div class="max-w-5xl mx-auto p-8">
    <div class="flex flex-row gap-8">
        <div class="w-1/2">
            <h1 class="text-3xl font-bold mb-8 text-center">New weight</h1>
            <form method="POST" action="{{ route('save-weight') }}" class="w-full bg-gray-50 p-8 rounded-lg">
                <div class="mb-4 flex gap-2 items-center">
                    <label class="w-16 font-bold" for="date">Date:</label>
                    <input class="flex-grow px-4 py-2 border" type="date" id="date" name="date"
                           value="{{ Carbon::now()->format('Y-m-d') }}"/>
                </div>
                <div class="mb-4 flex gap-2 items-center">
                    <label class="w-16 font-bold" for="weight">Weight:</label>
                    <input class="flex-grow px-4 py-2 border" autofocus onfocus="this.select();" type="number" step='0.1' id="weight"
                           name="weight" value="{{ $lastWeight->weight / 100 }}"/>
                </div>
                <div>
                    @csrf

                    <button class="w-full px-4 py-2 border bg-white font-bold">Save</button>
                </div>
            </form>
        </div>
        <div class="flex-grow">
            <h1 class="text-3xl font-bold mb-8 text-center">Last 5 days</h1>

            <div class="bg-gray-50 p-8 rounded-lg">
                <table class="border-collapse bg-white border border-rose-50 text-center w-full">
                    <tr class="bg-gray-500 text-white">
                        <th class="py-2">Date</th>
                        <th class="py-2">Weight</th>
                        <th class="py-2">Evolution</th>
                    </tr>
                    @foreach ($weights->slice(0, 5) as $key => $weight)
                        <tr @class([
                            'transition-all duration-500 hover:bg-rose-300 hover:scale-[1.1]',
                            'bg-rose-50' => $key % 2 === 1,
                            'border-2 border-rose-800 bg-gray-50' => $weight->date->isToday(),
                        ])>
                            <td class="py-2">{{ $weight->date->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $weight->weight / 100 }} kg</td>
                            <td class="py-2">
                                @php $evolution = $weight->evolutionSince((new Carbon($weight->date))->subDays()) @endphp
                                @if ($evolution > 0)
                                    <svg class="w-6 inline fill-red-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_1076_36064)"> <path d="M1.70711 18.7071C1.31658 19.0976 0.683417 19.0976 0.292893 18.7071C-0.0976311 18.3166 -0.0976311 17.6834 0.292893 17.2929L7.79289 9.79289C8.18342 9.40237 8.81658 9.40237 9.20711 9.79289L13.5 14.0858L20.5858 7H17C16.4477 7 16 6.55228 16 6C16 5.44772 16.4477 5 17 5H22.9993C23.0003 5 23.002 5 23.003 5C23.1375 5.0004 23.2657 5.02735 23.3828 5.07588C23.5007 5.12468 23.6112 5.19702 23.7071 5.29289C23.8902 5.47595 23.9874 5.71232 23.9989 5.95203C23.9996 5.96801 24 5.984 24 6C24 6.00033 24 5.99967 24 6V12C24 12.5523 23.5523 13 23 13C22.4477 13 22 12.5523 22 12V8.41421L14.2071 16.2071C13.8166 16.5976 13.1834 16.5976 12.7929 16.2071L8.5 11.9142L1.70711 18.7071Z"></path> </g> <defs> <clipPath id="clip0_1076_36064"> <rect width="24" height="24" fill="white"></rect> </clipPath> </defs> </g></svg>
                                    +{{ $evolution / 100 }} kg
                                @elseif ($evolution === 0)
                                    -
                                @else
                                    <svg class="w-6 inline fill-green-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_1076_36065)"> <path d="M1.70711 5.29289C1.31658 4.90237 0.683417 4.90237 0.292893 5.29289C-0.0976311 5.68342 -0.0976311 6.31658 0.292893 6.70711L7.79289 14.2071C8.18342 14.5976 8.81658 14.5976 9.20711 14.2071L13.5 9.91421L20.5858 17H17C16.4477 17 16 17.4477 16 18C16 18.5523 16.4477 19 17 19H22.9993L23.003 19C23.1375 18.9996 23.2657 18.9727 23.3828 18.9241C23.5007 18.8753 23.6112 18.803 23.7071 18.7071C23.8902 18.524 23.9874 18.2877 23.9989 18.048C23.9996 18.032 24 18.016 24 18V12C24 11.4477 23.5523 11 23 11C22.4477 11 22 11.4477 22 12V15.5858L14.2071 7.79289C13.8166 7.40237 13.1834 7.40237 12.7929 7.79289L8.5 12.0858L1.70711 5.29289Z"></path> </g> <defs> <clipPath id="clip0_1076_36065"> <rect width="24" height="24" fill="white"></rect> </clipPath> </defs> </g></svg>
                                    {{ $evolution / 100 }} kg
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if($weights->isEmpty())
                        <tr>
                            <td colspan="3" class="py-2">
                                No weight logged.
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="my-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Weight evolution</h1>

        <div class="bg-gray-50 p-8 rounded-lg">
            <table class="w-full text-center bg-white">
                @php
                    $lastWeek = $lastWeight->evolutionSince(new Carbon('last week')) / 100;
                    $lastMonth = $lastWeight->evolutionSince(new Carbon('last month')) / 100;
                    $lastQuarter = $lastWeight->evolutionSince(new Carbon('- 3 months')) / 100;
                    $lastSemester = $lastWeight->evolutionSince(new Carbon('- 6 months')) / 100;
                    $lastYear = $lastWeight->evolutionSince(new Carbon('last year')) / 100;
                @endphp
                <tr class="bg-gray-500 text-white">
                    <th class="py-2">Last week</th>
                    <th class="py-2">Last month</th>
                    <th class="py-2">Last quarter</th>
                    <th class="py-2">Last semester</th>
                    <th class="py-2">Last year</th>
                </tr>
                <tr>
                    <td class="pt-2 transition-all duration-500 hover:bg-rose-300 hover:scale-[1.1]">
                        {{ ($lastWeight->weight / 100) - $lastWeek }} kg

                        <div @class([
                            'text-green-700' => $lastWeek <= 0,
                            'text-red-700' => $lastWeek > 0,
                        ])>@if ($lastWeek >= 0)+@endif{{ $lastWeek }}</div>
                    </td>
                    <td class="pt-2 transition-all duration-500 hover:bg-rose-300 hover:scale-[1.1]">
                        {{ ($lastWeight->weight / 100) - $lastMonth }} kg

                        <div @class([
                            'text-green-700' => $lastMonth <= 0,
                            'text-red-700' => $lastMonth > 0,
                        ])>@if ($lastMonth >= 0)+@endif{{ $lastMonth }}</div>
                    </td>
                    <td class="p-2 transition-all duration-500 hover:bg-rose-300 hover:scale-[1.1]">
                        {{ ($lastWeight->weight / 100) - $lastQuarter }} kg

                        <div @class([
                            'text-green-700' => $lastQuarter <= 0,
                            'text-red-700' => $lastQuarter > 0,
                        ])>@if ($lastQuarter >= 0)+@endif{{ $lastQuarter }}</div>
                    </td>
                    <td class="p-2 transition-all duration-500 hover:bg-rose-300 hover:scale-[1.1]">
                        {{ ($lastWeight->weight / 100) - $lastSemester }} kg

                        <div @class([
                            'text-green-700' => $lastSemester <= 0,
                            'text-red-700' => $lastSemester > 0,
                        ])>@if ($lastSemester >= 0)+@endif{{ $lastSemester }}</div>
                    </td>
                    <td class="pt-2 transition-all duration-500 hover:bg-rose-300 hover:scale-[1.1]">
                        {{ ($lastWeight->weight / 100) - $lastYear }} kg

                        <div @class([
                            'text-green-700' => $lastYear <= 0,
                            'text-red-700' => $lastYear > 0,
                        ])>@if ($lastYear >= 0)+@endif{{ $lastYear }}</div>
                    </td>
                </tr>
            </table>

            <div id="chartContainer" class="w-full h-96 mt-8 relative"></div>

        </div>
    </div>


    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        const data = @php
            echo json_encode($weights->map(fn ($weight) => [
                'x' => $weight->date,
                'y' => $weight->weight,
            ]));
        @endphp

        const chart = new CanvasJS.Chart('chartContainer', {
            animationEnabled: true,
            data: [{
                type: 'line',
                dataPoints: data.map(item => ({
                    x: new Date(item.x),
                    y: item.y / 100
                }))
            }]
        });
        chart.render();
    </script>
</div>
</body>
</html>
