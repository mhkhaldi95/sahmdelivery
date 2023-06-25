<?php

namespace App\Http\Controllers\Notifications;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trips\TripRequest;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\Trips\TripResource;
use App\Models\Constant;
use App\Models\Notification;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function notificationsHeader(Request $request){
        $user = User::query()->where('role',Enum::SUPER_ADMIN)->first();
        $notifications = $user->notifications()->paginate(20);
        $count_notifications = $user->unreadNotifications()->count();
        $notifications = NotificationResource::collection($notifications)->resolve();
        $notifications = view('_notifications',compact('notifications'))->render();
        return response()->json([
            'status' =>true,
            'data' =>[
                'notifications' =>$notifications,
                'count_notifications' =>$count_notifications,
            ],
        ]);

    }

}
