<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CompleteTripDaily;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request){
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'الاحصائيات','active' => false],
        ];

        $trip_count = Trip::query()->filter()->count();
        $complete_trip_count = Trip::query()->filter()->completed()->count();
        $pending_trip_count = Trip::query()->filter()->pending()->count();
        $canceled_trip_count = Trip::query()->filter()->cancel()->count();
        $total_amount = CompleteTripDaily::query()->filter()->sum('total_amount');
        $total_amount_for_captain = CompleteTripDaily::query()->filter()->sum('total_amount_for_captain');
        $total_amount_for_office = CompleteTripDaily::query()->filter()->sum('total_amount_for_office');
        $captains = User::query()->captains()->get();
        return view('statistics',[
            'page_title' =>'الاحصائيات',
            'page_breadcrumbs' => $page_breadcrumbs,
            'captains' => $captains,

            'trip_count' => $trip_count,
            'complete_trip_count' => $complete_trip_count,
            'pending_trip_count' => $pending_trip_count,
            'canceled_trip_count' => $canceled_trip_count,
            'total_amount' => $total_amount,
            'total_amount_for_captain' => $total_amount_for_captain,
            'total_amount_for_office' => $total_amount_for_office,

        ]);
    }
}
