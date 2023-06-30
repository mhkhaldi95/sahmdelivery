<?php

namespace App\Providers;

use App\Constants\Enum;
use App\Http\Resources\NotificationResource;
use App\Models\Constant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('constants', Constant::query()->get());
//        View::composer('*', function ($view) {
//            if (Auth::check()) {
//                $user = User::query()->where('role',Enum::SUPER_ADMIN)->first();
//                $notifications = $user->notifications()->with(['notifiable'])->paginate(20);
//                $notifications = NotificationResource::collection($notifications)->resolve();
//                $count_notifications = $user->unreadNotifications()->count();
//                $view->with('notifications', $notifications);
//                $view->with('count_notifications', $count_notifications);
//            }
//        });
    }
}
