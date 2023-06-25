<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\Trips\TripController;
use App\Http\Controllers\PlaceDashboard\Trips\TripController as PlaceTripController;
use App\Http\Controllers\UserManagement\Captains\CaptainController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaceDashboard\DashboardController as PlaceDashboardController;
use App\Http\Controllers\UserManagement\Admins\AccountSettingsController;
use App\Http\Controllers\UserManagement\Customers\CustomerController;
use App\Http\Controllers\UserManagement\Places\PlaceController;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('notifications/{id}/readAt', function ($id) {

    try {
        $notify = Notification::query()->where('id', $id)->first();
        $notify->update(['read_at' => now()]);
        $page_breadcrumbs = [
            ['page' => route('dashboard.index'), 'title' => 'الرئيسية', 'active' => true],
            ['page' => '#', 'title' => 'الرحلات', 'active' => false],
        ];
        $customers = User::query()->customers()->get();
        $places = User::query()->places()->get();
        $captains = User::query()->captains()->get();
        return redirect()->route('trips.index')->with(
            [
                'page_title' => 'الرئيسية',
                'page_breadcrumbs' => $page_breadcrumbs,
                'customers' => $customers,
                'captains' => $captains,
                'places' => $places,
            ]
        );


    } catch (QueryException $exception) {
        return $this->invalidIntParameter();
    }

})->name('notifications.readAt');
Route::get('notifications/header', [NotificationController::class, 'notificationsHeader'])->name('notifications.header');


Route::group(['prefix' => 'admin', 'middleware' => 'locale'], function () {
    Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::post('custom-login', [LoginController::class, 'login'])->name('custom-login');
    });
});
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');

    Route::group(['prefix' => 'auth'], function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout')->withoutMiddleware('admin');
    });


    Route::get('{id}/account', [AccountSettingsController::class, 'create'])->name('admins.account.create')->withoutMiddleware('admin');
    Route::post('account/update-info', [AccountSettingsController::class, 'updateInfo'])->name('admins.account.update-info')->withoutMiddleware('admin');
    Route::post('account/update-username', [AccountSettingsController::class, 'updateUsername'])->name('admins.account.update-username')->withoutMiddleware('admin');
    Route::post('account/update-password', [AccountSettingsController::class, 'updatePassword'])->name('admins.account.update-password')->withoutMiddleware('admin');


    Route::group(['prefix' => 'captains'], function () {
        Route::get('/', [CaptainController::class, 'index'])->name('captains.index');
        Route::get('/create/{id?}', [CaptainController::class, 'create'])->name('captains.create');
        Route::post('/store/{id?}', [CaptainController::class, 'store'])->name('captains.store');
        Route::post('{id}/delete', [CaptainController::class, 'delete'])->name('captains.delete');
        Route::get('{id}/trips', [CaptainController::class, 'trips'])->name('captains.trips');

    });

    Route::group(['prefix' => 'places'], function () {
        Route::get('/', [PlaceController::class, 'index'])->name('places.index');
        Route::get('/create/{id?}', [PlaceController::class, 'create'])->name('places.create');
        Route::post('/store/{id?}', [PlaceController::class, 'store'])->name('places.store');
        Route::post('{id}/delete', [PlaceController::class, 'delete'])->name('places.delete');
        Route::get('{id}/trips', [PlaceController::class, 'trips'])->name('places.trips');


    });
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/create/{id?}', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/store/{id?}', [CustomerController::class, 'store'])->name('customers.store');
        Route::post('{id}/delete', [CustomerController::class, 'delete'])->name('customers.delete');
        Route::get('{id}/trips', [CustomerController::class, 'trips'])->name('customers.trips');

    });
    Route::group(['prefix' => 'trips'], function () {
        Route::get('/', [TripController::class, 'index'])->name('trips.index');
        Route::get('/create/{id?}', [TripController::class, 'create'])->name('trips.create');
        Route::post('/store/{id?}', [TripController::class, 'store'])->name('trips.store');
        Route::post('{id}/cancel', [TripController::class, 'cancel'])->name('trips.cancel');
        Route::post('cancel-selected', [TripController::class, 'cancelSelected'])->name('trips.cancel_selected');
        Route::post('complete-selected', [TripController::class, 'completeSelected'])->name('trips.complete_selected');
        Route::post('close-selected', [TripController::class, 'closeSelected'])->name('trips.close_selected');
        Route::post('update-price', [TripController::class, 'updatePrice'])->name('trips.update_price');
        Route::post('update-from', [TripController::class, 'updateFrom'])->name('trips.update_from');
        Route::post('update-to', [TripController::class, 'updateTo'])->name('trips.update_to');
    });
    Route::group(['prefix' => 'constants'], function () {
        Route::get('/create', [ConstantController::class, 'create'])->name('constants.create');
        Route::post('/store', [ConstantController::class, 'store'])->name('constants.store');
    });

});


Route::group(['prefix' => 'places', 'middleware' => 'locale'], function () {
    Route::group(['middleware' => ['auth:sanctum', 'place']], function () {
        Route::get('/index', [PlaceDashboardController::class, 'index'])->name('places.dashboard.index');

        Route::group(['prefix' => 'trips'], function () {
            Route::get('/', [PlaceTripController::class, 'index'])->name('places.trips.index');
            Route::post('/store', [PlaceTripController::class, 'store'])->name('places.trips.store');
            Route::post('cancel-selected', [PlaceTripController::class, 'cancelSelected'])->name('places.trips.cancel_selected');
        });
    });
});
