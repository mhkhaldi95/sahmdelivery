<?php

namespace App\Http\Controllers\PlaceDashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $page_breadcrumbs = [
            ['page' => '#' , 'title' =>'الرئيسية','active' => false],
        ];

        return view('place_dashboard.dashboard',[
            'page_title' =>'الرئيسية',
            'page_breadcrumbs' => $page_breadcrumbs,
        ]);
    }
}
