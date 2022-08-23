<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Helpers\Chart;

Route::get('/', function () {
    $year = request('year', date('Y'));
    $thisYearOrders = Order::getYearOrders($year)
        ->groupByMonth();

    $lastYearOrders = Order::getYearOrders($year - 1)
        ->groupByMonth();

    return Inertia::render('Home', [
        'orders' => [
            'thisYearOrders' => $thisYearOrders,
            'lastYearOrders' => $lastYearOrders,
        ],
        'filter' => [
            'year' => $year
        ]
    ]);
});

Route::get('dashboard', function () {
    $from = request('from', now()->subYear());
    $to = request('to', now());

    $chart = new Chart($from, $to);

    return Inertia::render('Dashboard', [
        'charts' => [
            'orders' => $chart
                ->setQuery(Order::query())
                ->whereBetween()
                ->getDataByMonth(),
            'users' => $chart
                ->setQuery(User::query())
                ->whereBetween()
                ->getDataByMonth()
        ]
    ]);
});







// Order::whereMonth('created_at', '08')
//     ->whereYear('created_at', '2021')
//     ->whereDay('created_at', '>=', '21')->delete();
// $charts = [
//     'orders' => [
//         'Aug 2021' => 0,
//         'Sep 2021' => 20,
//         'Oct 2021' => 1,
//         'Nov 2021' => 25,
//         'Dec 2021' => 13,
//         'Jan 2022' => 44,
//         'Feb 2022' => 2,
//         'Mar 2022' => 90,
//         'Apr 2022' => 56,
//         'May 2022' => 78,
//         'Jun 2022' => 0,
//         'Jul 2022' => 33,
//         'Aug 2022' => 9,
//     ],
//     'users' => [
//         'Aug 2021' => 30,
//         'Sep 2021' => 25,
//         'Oct 2021' => 12,
//         'Nov 2021' => 55,
//         'Dec 2021' => 43,
//         'Jan 2022' => 4,
//         'Feb 2022' => 20,
//         'Mar 2022' => 0,
//         'Apr 2022' => 100,
//         'May 2022' => 50,
//         'Jun 2022' => 70,
//         'Jul 2022' => 0,
//         'Aug 2022' => 79,
//     ]
// ];