<?php

namespace App\Http\Controllers\Trips;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trips\TripRequest;
use App\Http\Resources\Trips\TripResource;
use App\Models\CompleteTripDaily;
use App\Models\Constant;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{

    public function index(Request $request){
        if($request->ajax()){
            $length = \request()->get('length', 10);
            if(\request()->get('length') && \request()->get('length') == -1){
                $length = Trip::query()->count();
            }
            $items = Trip::query()->with(['captain','owner'])->orderBy(getColAndDirForOrderBy()['col'],getColAndDirForOrderBy()['dir'])->filter()
                ->paginate($length,'*','*',getPageNumber($length));
            return datatable_response($items, null, TripResource::class);
        }
        $customers = User::query()->customers()->get();
        $places = User::query()->places()->get();
        $captains = User::query()->captains()->get();
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'الرحلات','active' => false],
        ];
        return view('trips.index', [
            'page_title' =>'الرئيسية',
            'page_breadcrumbs' => $page_breadcrumbs,
            'customers' => $customers,
            'captains' => $captains,
            'places' => $places,
        ]);
    }
    public function create($id = null)
    {
        $page_title = __('lang.create');
        if (isset($id)) {
            $page_title = __('lang.edit');
            try {
                $item = Trip::query()->filter()->findOrFail($id);
            } catch (QueryException $exception) {
                return $this->invalidIntParameter();
            }
        }
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => route('trips.index') , 'title' =>'الرحلات','active' => true],
            ['page' => '#' , 'title' =>isset($id)?__('lang.edit'):__('lang.add'),'active' => false],
        ];

        $customers = User::query()->active()->customers()->get();
        $places = User::query()->active()->places()->get();
//        $captains = User::query()->captains()->get();
        $captain_ids = User::captainReadyForTrips();
        if(isset($item) && !is_null($item->captain_id)){
            $captain_ids = array_diff($captain_ids, [$item->captain_id]);
        }
        $captains = User::query()->active()->captains()->whereNotIn('id',$captain_ids)->get();

        return view('trips.create', [
            'page_title' =>$page_title,
            'page_breadcrumbs' => $page_breadcrumbs,
            'item' => @$item,
            'customers' => $customers,
            'captains' => $captains,
            'places' => $places,
        ]);
    }
    public function store(TripRequest $request, $id = null)
    {
      try {
          $data = $request->only(Trip::FILLABLE);
          if($request->get('owner',null) == 'place'){
              $data['owner_id'] = $request->get('place_id',null);
              $data['is_owner_place'] = 1;
              $data['payment_type'] = Enum::POSTPAID;
          }else{
              $data['owner_id'] = $request->get('customer_id',null);
              $data['is_owner_place'] = 0;
              $data['payment_type'] = Enum::IMMEDIATELY;
          }
          if($data['amount'] > 0){
              $data['customer_paid'] = 1;
          }
          DB::beginTransaction();
            $item = Trip::query()->updateOrCreate([
                'id' => $id,
            ], $data);
            DB::commit();

            return $this->returnBackWithSaveDone();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->returnBackWithSaveDoneFailed();
        }
    }



    public function completeSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            DB::beginTransaction();
            $constants = Constant::query()->get();
            $ratio = getConstantByKey($constants,'ratio')->value;
            $fix_amount = getConstantByKey($constants,'fix_amount')->value;

            $date = \DateTime::createFromFormat('m/d/Y', $request->completed_at);
            $formattedDate = $date->format('Y/m/d');
           $item =  CompleteTripDaily::query()->create([
               'completed_at' =>$formattedDate ,
               'ids_trips' => $ids,
               'ratio' => $ratio,
               'fix_amount' => $fix_amount,
               'captain_id' => $request->get('captain_id',null)
            ]);
            $result = Trip::query()->pending()->closed()->whereIn('id', $ids)->update([
                'status' => Enum::COMPLETED,
                'complete_trip_daily_id' => $item->id
            ]);
            if ($result) {
                $totalAmount = DB::table('trips')
                    ->whereIn('id', $ids)
                    ->sum('amount');
                $TotalAmountAfterDiscountForOffice = $totalAmount ? (($totalAmount * $ratio) + floatval($fix_amount)) : 0;
                $decimalPart = $TotalAmountAfterDiscountForOffice - floor($TotalAmountAfterDiscountForOffice);

                if ($decimalPart >= 0.44) {
                    $TotalAmountAfterDiscountForOffice = floor($TotalAmountAfterDiscountForOffice) + 1;
                } else {
                    $TotalAmountAfterDiscountForOffice = floor($TotalAmountAfterDiscountForOffice);
                }

                $TotalAmountAfterDiscount = $totalAmount - $TotalAmountAfterDiscountForOffice;


                $item->update([
                    'total_amount' =>$totalAmount,
                    'total_amount_for_captain' =>$TotalAmountAfterDiscount,
                    'total_amount_for_office' =>$TotalAmountAfterDiscountForOffice,
                ]);
            }
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function closeSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
           $closed_amount =  Constant::query()->where('key','=','closed_amount')->firstOrFail();
            $result = Trip::query()->notClosed()->whereIn('id', $ids)->update([
                'amount' => $closed_amount?$closed_amount->value:null
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function updatePrice(Request $request)
    {
        $id = $request->get('id');
        $amount = $request->get('amount');
        try {
            if($id && ($amount || $amount >=0)){
                $result = Trip::query()->findOrFail($id)->update([
                    'amount' => $amount
                ]);
            }else{
                return $this->invalidIntParameterJson();
            }

        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function updateFrom(Request $request)
    {
        $id = $request->get('id');
        $from = $request->get('from');
        try {
            if($id && $from){
                $result = Trip::query()->findOrFail($id)->update([
                    'from' => $from
                ]);
            }else{
                return $this->invalidIntParameterJson();
            }

        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function updateTo(Request $request)
    {
        $id = $request->get('id');
        $to = $request->get('to');
        try {
            if($id && $to){
                $result = Trip::query()->findOrFail($id)->update([
                    'to' => $to
                ]);
            }else{
                return $this->invalidIntParameterJson();
            }

        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
    public function cancelSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            $result = Trip::query()->pending()->whereIn('id', $ids)->update([
                'status' => Enum::CANCELED
            ]);
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }

        return $this->response_json(true, StatusCodes::OK, 'تمت العملية بنجاح');


    }
}