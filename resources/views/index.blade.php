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
        }

        #mood input:not(:checked) ~ svg {
            stroke: rgb(214 211 209);
        }
    </style>
</head>
<body class="antialiased">
<div class="max-w-7xl mx-auto p-8">
    <div class="flex flex-row gap-8 my-8">
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
        <div class="w-1/2">
            <h1 class="text-3xl font-bold mb-8 text-center">New mood</h1>
            <form method="POST" action="{{ route('save-mood') }}" class="w-full bg-gray-50 p-8 rounded-lg" id="mood">
                <div class="mb-4 flex gap-2 items-center">
                    <label class="w-16 font-bold" for="date">Date:</label>
                    <input class="flex-grow px-4 py-2 border" type="date" id="date" name="date"
                           value="{{ Carbon::yesterday()->format('Y-m-d') }}"/>
                </div>
                <div class="mb-4 flex gap-2 items-center">
                    <label class="w-16 font-bold" for="weight">Mood:</label>
                    <div class="flex flex-grow">
                        <label class="w-1/4 flex justify-center">
                            <input class="hidden" type="radio" name="mood" value="1"/>

                            <svg class="w-10 transition-all duration-300 stroke-red-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 23.25C18.2132 23.25 23.25 18.2132 23.25 12C23.25 5.7868 18.2132 0.75 12 0.75C5.7868 0.75 0.75 5.7868 0.75 12C0.75 18.2132 5.7868 23.25 12 23.25Z" />
                                <path d="M14.5176 9.02881C14.6749 9.45542 14.9578 9.82463 15.3294 10.0875C15.7094 10.3562 16.1633 10.5005 16.6287 10.5005C17.0941 10.5005 17.548 10.3562 17.9279 10.0875C18.2995 9.82463 18.5825 9.45542 18.7398 9.02881" />
                                <path d="M5.26123 9.03113C5.41868 9.45676 5.70128 9.82511 6.07222 10.0875C6.45216 10.3562 6.90609 10.5005 7.37147 10.5005C7.83685 10.5005 8.29078 10.3562 8.67073 10.0875C9.04167 9.82511 9.32427 9.45676 9.48172 9.03113" />
                                <path d="M5.98779 17.676C6.54712 16.583 7.39418 15.6627 8.43834 15.0148C9.50731 14.3515 10.7403 14 11.9984 14C13.2565 14 14.4895 14.3515 15.5585 15.0148C16.6026 15.6627 17.4497 16.583 18.009 17.676" />
                            </svg>
                        </label>

                        <label class="w-1/4 flex justify-center">
                            <input class="hidden" type="radio" name="mood" value="2"/>

                            <svg class="w-10 transition-all duration-300 stroke-yellow-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 23.25C18.2132 23.25 23.25 18.2132 23.25 12C23.25 5.7868 18.2132 0.75 12 0.75C5.7868 0.75 0.75 5.7868 0.75 12C0.75 18.2132 5.7868 23.25 12 23.25Z" />
                                <path d="M7.5 15.75H16.5" />
                                <path d="M9.493 9C9.33798 9.4388 9.05071 9.81874 8.67076 10.0875C8.29081 10.3562 7.83688 10.5005 7.3715 10.5005C6.90612 10.5005 6.45219 10.3562 6.07224 10.0875C5.69229 9.81874 5.40502 9.4388 5.25 9" />
                                <path d="M14.5176 9.02963C14.6749 9.4559 14.9577 9.82481 15.3291 10.0875C15.7091 10.3562 16.163 10.5005 16.6284 10.5005C17.0938 10.5005 17.5477 10.3562 17.9276 10.0875C18.299 9.82481 18.5818 9.4559 18.7392 9.02963" />
                            </svg>
                        </label>

                        <label class="w-1/4 flex justify-center">
                            <input class="hidden" type="radio" name="mood" checked="checked" value="3"/>

                            <svg class="w-10 transition-all duration-300 stroke-emerald-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 23.25C18.2132 23.25 23.25 18.2132 23.25 12C23.25 5.7868 18.2132 0.75 12 0.75C5.7868 0.75 0.75 5.7868 0.75 12C0.75 18.2132 5.7868 23.25 12 23.25Z" />
                                <path d="M18.75 10.5005C18.595 10.0617 18.3077 9.68178 17.9278 9.41305C17.5478 9.14432 17.0939 9.00001 16.6285 9.00001C16.1631 9.00001 15.7092 9.14432 15.3292 9.41305C14.9551 9.67765 14.6709 10.0501 14.5142 10.4803" />
                                <path d="M5.25018 10.5005C5.4052 10.0617 5.69247 9.68178 6.07242 9.41305C6.45237 9.14432 6.9063 9.00001 7.37168 9.00001C7.83706 9.00001 8.29099 9.14432 8.67094 9.41305C9.03808 9.67272 9.31868 10.0362 9.47705 10.4563" />
                                <path d="M5.94824 15C6.50681 16.1273 7.3692 17.076 8.43818 17.7394C9.50715 18.4027 10.7402 18.7542 11.9982 18.7542C13.2563 18.7542 14.4893 18.4027 15.5583 17.7394C16.6202 17.0804 17.4782 16.1399 18.0371 15.0224" />
                            </svg>
                        </label>

                        <label class="w-1/4 flex justify-center">
                            <input class="hidden" type="radio" name="mood" value="4"/>

                            <svg class="w-10 transition-all duration-300 stroke-blue-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 23.25C18.2132 23.25 23.25 18.2132 23.25 12C23.25 5.7868 18.2132 0.75 12 0.75C5.7868 0.75 0.75 5.7868 0.75 12C0.75 18.2132 5.7868 23.25 12 23.25Z" />
                                <path d="M11.9982 18.7542C13.2563 18.7542 14.4893 18.4027 15.5583 17.7394C16.6202 17.0804 17.4782 16.1399 18.0371 15.0224L5.94824 15C6.50681 16.1273 7.3692 17.076 8.43818 17.7394C9.50715 18.4027 10.7402 18.7542 11.9982 18.7542Z" />
                                <path d="M18.75 10.5005C18.595 10.0617 18.3077 9.68178 17.9278 9.41305C17.5478 9.14432 17.0939 9.00001 16.6285 9.00001C16.1631 9.00001 15.7092 9.14432 15.3292 9.41305C14.9572 9.67617 14.6741 10.0459 14.5169 10.4731" />
                                <path d="M5.25004 10.5005C5.40506 10.0617 5.69233 9.68178 6.07228 9.41305C6.45223 9.14432 6.90616 9.00001 7.37154 9.00001C7.83692 9.00001 8.29085 9.14432 8.6708 9.41305C9.04416 9.67713 9.32804 10.0486 9.48486 10.4778" />
                            </svg>
                        </label>
                    </div>
                </div>
                <div>
                    @csrf

                    <button class="w-full px-4 py-2 border bg-white font-bold">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="flex flex-row gap-8 my-8">
        <div class="w-1/2">
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
                                @php $evolution = $weight->evolutionSince($weight->previous()->date) @endphp
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

            <h1 class="text-3xl font-bold mb-8 text-center">Weight evolution</h1>

            <div class="bg-gray-50 p-8 rounded-lg">
                <table class="w-full text-center bg-white">
                    @php
                        $lastWeek = $lastWeight->evolutionSince(Carbon::now()->subWeek()) / 100;
                        $lastMonth = $lastWeight->evolutionSince(Carbon::now()->subMonth()) / 100;
                        $lastQuarter = $lastWeight->evolutionSince(Carbon::now()->subMonths(3)) / 100;
                        $lastSemester = $lastWeight->evolutionSince(Carbon::now()->subMonths(6)) / 100;
                        $lastYear = $lastWeight->evolutionSince(Carbon::now()->subYear()) / 100;
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
        <div class="w-1/2">
            <h1 class="text-3xl font-bold mb-8 text-center">Mood evolution</h1>

            <div class="flex justify-center border">
                <div class="text-center divide-y">
                    <div class="w-full h-8"></div>
                    @for($i = 1; $i <= 31; ++$i)
                        <div class="h-5 w-8 text-xs text-center flex items-center bg-slate-100">
                            <div class="w-full">{{ sprintf('%02d', $i) }}</div>
                        </div>
                    @endfor
                </div>
                <div class="flex flex-row grow divide-x border-l">
                    @foreach($moodsGroupByMonth as $moods)
                        <div class="grow">
                            <div class="text-xs h-8 flex items-center bg-slate-100 border-b">
                                <div class="w-full text-center">{{ substr($moods->getMonthName(), 0, 3) }}.</div>
                            </div>
                            <div @class([
                                'flex flex-col divide-y ',
                                'border-b' => count($moods) < 31,
                            ])>
                                @foreach($moods as $mood)
                                    <div @class([
                                        'w-full h-5',
                                        'bg-slate-50' => $mood->value === 0 && ! $mood->date->isToday(),
                                        'bg-red-300' => $mood->value === 1,
                                        'bg-yellow-200' => $mood->value === 2,
                                        'bg-emerald-300' => $mood->value === 3,
                                        'bg-blue-300' => $mood->value === 4,
                                        'bg-slate-400' => $mood->date->isToday()
                                    ]) title="{{ $mood->date->format('d/m/Y') }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
