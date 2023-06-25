<?php

namespace App\Http\Controllers\PlaceDashboard\Trips;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trips\TripRequest;
use App\Http\Resources\Trips\TripResource;
use App\Jobs\RequestSahmNotificationQueue;
use App\Models\Constant;
use App\Models\Trip;
use App\Models\User;
use App\Notifications\RequestSahmNotification;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

class TripController extends Controller
{

    public function index(Request $request){
        if($request->ajax()){
            $length = \request()->get('length', 10);
            if(\request()->get('length') && \request()->get('length') == -1){
                $length = Trip::query()->placeTrips()->count();
            }
            $items = Trip::query()->placeTrips()->with(['captain','owner'])->orderBy(getColAndDirForOrderBy()['col'],getColAndDirForOrderBy()['dir'])->filter()
                ->paginate($length,'*','*',getPageNumber($length));
            return datatable_response($items, null, TripResource::class);
        }
        $customers = User::query()->customers()->get();
        $captains = User::query()->captains()->get();
        $page_breadcrumbs = [
            ['page' => route('places.trips.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'الرحلات','active' => false],
        ];
        return view('place_dashboard.trips.index', [
            'page_title' =>'الرئيسية',
            'page_breadcrumbs' => $page_breadcrumbs,
            'customers' => $customers,
            'captains' => $captains,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'qty_captain' => 'required'
        ],[
          'qty_captain.required' =>'عدد الكباتن مطلوب'
        ]);
        try {
            $admin = User::query()->where('role',Enum::SUPER_ADMIN)->firstOrFail();
            $place = auth()->user()->name;
            $place_id = auth()->user()->id;
            if($request->type == Enum::LATER){
                $delay = Carbon::now()->addMinutes($request->come_at);
                Queue::later($delay, new RequestSahmNotificationQueue([
                    'request' => $request->all(),
                    'user'=>$admin,
                    'place_id'=>$place_id,
                    'place'=>$place,
                    'qty'=>$request->qty_captain,
                    'come_at'=>$request->come_at,
                    'address'=>auth()->user()->address,
                    'type'=>$request->type,
                ]));
            }else{

                $come_at = null;
                if($request->come_at){
                    $come_at = Carbon::now()->addMinutes($request->come_at);
                }
                for($i = 1; $i <= $request->qty_captain ; $i++){
                    Trip::query()->create([
                        'owner_id' => auth()->user()->id,
                        'is_owner_place' =>1,
                        'from' => auth()->user()->address,
                        'type' => $request->type??Enum::IMMEDIATELY,
                        'come_at' => $come_at,
                    ]);
                }

                Notification::send($admin, new RequestSahmNotification([
                    'place_id' => auth()->user()->id,
                    'title' => 'طلب جديد',
                    'body' => "$place طلب $request->qty_captain كابتن",
                    'type' => 'new_request_sahm',
                ]));
            }
            return back()->with([
                'message' => 'تم الطلب بنجاح',
                'alert-type' => 'success'
            ]);
        } catch (QueryException $exception) {
            return back()->with([
                'message' => 'حذث خطأ',
                'alert-type' => 'error'
            ]);
        }


    }



    public function completeSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            $result = Trip::query()->placeTrips()->closed()->whereIn('id', $ids)->update([
                'status' => Enum::COMPLETED
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function closeSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
           $closed_amount =  Constant::query()->where('key','=','closed_amount')->firstOrFail();
            $result = Trip::query()->placeTrips()->notClosed()->whereIn('id', $ids)->update([
                'amount' => $closed_amount?$closed_amount->value:null
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function cancelSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            $result = Trip::query()->placeTrips()->pending()->whereIn('id', $ids)->update([
                'status' => Enum::CANCELED
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
}
