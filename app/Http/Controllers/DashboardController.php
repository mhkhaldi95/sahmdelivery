<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\StartEndTime;
use App\Models\Trip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $start_end_time = StartEndTime::query()->orderByDesc('created_at')->first();
        $recent_trips = [];
        $captains_most_trips_for_day = [];
        if($start_end_time && is_null($start_end_time->end_time)){
            $captains_most_trips_for_day = Trip::query()
                ->with(['captain'])
                ->select('captain_id')
                ->selectRaw('COUNT(*) AS trip_count')
                ->where('created_at','>=',$start_end_time->start_time)
                ->groupBy('captain_id')
                ->orderBy('trip_count', 'desc')
                ->get();

            $recent_trips = Trip::query()
                ->with(['captain','owner'])
                 ->where('created_at','>=',$start_end_time->start_time)
                ->orderByDesc('created_at')
                ->take(15)
                ->get();
        }

        $page_breadcrumbs = [
            ['page' => '#', 'title' => 'الرئيسية', 'active' => false],
        ];

        return view('dashboard', [
            'page_title' => 'الرئيسية',
            'page_breadcrumbs' => $page_breadcrumbs,
            'captains_most_trips_for_day' => $captains_most_trips_for_day,
            'recent_trips' => $recent_trips,
        ]);
    }
}
