<?php

namespace App\Http\Controllers;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\CompleteTripDaily;
use App\Models\Constant;
use App\Models\StartEndTime;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StartEndTimeController extends Controller
{
    public function startTime()
    {

        try {
            $item = StartEndTime::query()->create([
                'start_time' => now(),
            ]);
            return back()->with([
                'message' => 'تم بدء الدواء بنجاح',
                'alert-type' => 'success'
            ]);
        } catch (QueryException $exception) {
            DB::rollBack();
            return back()->with([
                'message' => 'حدث خطأ ما',
                'alert-type' => 'error'
            ]);
        }
    }

    public function endTime($id)
    {
        try {
            DB::beginTransaction();

            $constants = Constant::query()->get();
            $closed_amount = getConstantByKey($constants,'closed_amount')->value;


            $item = StartEndTime::query()->findOrFail($id);
            $ids_trips = Trip::query()
                ->where('created_at', '>=', $item->start_time)
                ->where('created_at', '<=', now())
                ->pluck('id')
                ->toArray();


            $trips =  Trip::query()
                ->where('created_at', '>=', $item->start_time)
                ->where('created_at', '<=', now())
                ->where('amount',null)
                ->where('status',Enum::PENDING)
                ->update(['amount' =>$closed_amount]);

            $item->update([
                'end_time' => now(),
                'ids_trips' => $ids_trips,
            ]);
            DB::commit();
            return redirect()->route('dashboard.index')->with([
                'message' => 'تم انهاء الدواء بنجاح',
                'alert-type' => 'success'
            ]);
        } catch (QueryException $exception) {
            DB::rollBack();
            return back()->with([
                'message' => 'حدث خطأ ما',
                'alert-type' => 'error'
            ]);
        }

    }
    public function getDay(Request $request)
    {
        try {

            if($request->get('type') == 'prev'){
                $operation = '<';
                $dir = 'desc';
            }else{
                $operation = '>';
                $dir = 'asc';
            }
            $item = StartEndTime::query()
                ->where('id', $operation, $request->id)
                ->orderBy('id', $dir)
                ->first();

            return response()->json([
                'status'=>true,
                'data' =>[
                    'item' =>$item
                ]
            ]);


        } catch (QueryException $exception) {
            return response()->json([
                'status'=>false,
                'data' =>[],
                'msg' =>'حدث خطأ ما'
            ]);
        }

    }

}
