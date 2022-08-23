<?php

namespace App\Helpers;

use Carbon\Carbon;

class Chart
{
    protected $query;
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = Carbon::parse($from)->startOfMonth();
        $this->to =  Carbon::parse($to)->endOfDay();
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function whereBetween()
    {
        $formatFrom = $this->from->format('Y-m-d H:i:s');
        $formatTo = $this->to->format('Y-m-d H:i:s');
        $this->query->whereBetween('created_at', [$formatFrom, $formatTo]);
        return $this;
    }

    public function getDataByMonth()
    {
        $data = $this->query->orderBy('created_at')
            ->get()
            ->groupBy(function ($query) {
                return Carbon::parse($query->created_at)->format('M Y');
            })
            ->map(function ($query) {
                return $query->count();
            })
            ->toArray();

        return $this->fallbackMonth($data);
    }

    public function fallbackMonth($data)
    {
        $months = [];
        $start = Carbon::parse($this->from);
        $end = Carbon::parse($this->to);

        while ($start < $end) {
            $formatMonth = $start->format('M Y');
            if (array_key_exists($formatMonth, $data)) {
                $months[$formatMonth] = $data[$formatMonth];
            } else {
                $months[$formatMonth] = 0;
            }

            $start->addMonth();
        }

        return $months;
    }

    // public function fallbackMonth2($data)
    // {
    //     $months = [];

    //     foreach (CarbonPeriod::create($this->from, '1 month', $this->to) as $month) {
    //         dump($month->format('M Y'));
    //         $formatMonth = $month->format('M Y');
    //         if (array_key_exists($formatMonth, $data)) {
    //             $months[$formatMonth] = $data[$formatMonth];
    //         } else {
    //             $months[$formatMonth] = 0;
    //         }
    //     }

    //     return $months;
    // }
}
