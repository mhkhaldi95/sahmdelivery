<?php

namespace App\Http\Controllers\Constant;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trips\TripRequest;
use App\Http\Resources\Trips\TripResource;
use App\Models\Constant;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConstantController extends Controller
{

    public function create($id = null)
    {
        $page_title = __('lang.edit');
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'ثوابت النظام','active' => false],
        ];


        return view('constants.create', [
            'page_title' =>$page_title,
            'page_breadcrumbs' => $page_breadcrumbs,
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        try {
            DB::beginTransaction();

            foreach ($data as $key=>$value){
                $row = Constant::query()->where('key',$key)->firstOrFail();
                if($row && $value){
                    $row->update(['value' => $value]);
                }


            }
            DB::commit();
            return $this->returnBackWithSaveDone();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->returnBackWithSaveDoneFailed();
        }
    }

}
