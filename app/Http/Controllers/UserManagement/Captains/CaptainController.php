<?php

namespace App\Http\Controllers\UserManagement\Captains;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\Captains\CaptainRequest;
use App\Http\Resources\Trips\TripResource;
use App\Http\Resources\UserManagement\Captains\CaptainResource;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaptainController extends Controller
{

    public function index(Request $request){
        if($request->ajax()){
            $length = \request()->get('length', 10);
            $items = User::query()->orderByDesc('id')->captains()->filter()->paginate(\request()->get('length', 10),'*','*',getPageNumber($length));
            return datatable_response($items, null, CaptainResource::class);
        }
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'الكباتن','active' => false],
        ];
        return view('user_management.captains.index', [
            'page_title' =>'الرئيسية',
            'page_breadcrumbs' => $page_breadcrumbs,
        ]);
    }
    public function trips(Request $request,$id){
        if($request->ajax()){
            $length = \request()->get('length', 10);
            if(\request()->get('length') && \request()->get('length') == -1){
                $length = Trip::query()->count();
            }
            $items = Trip::query()->where('captain_id',$id)->with(['captain','owner'])->orderBy(getColAndDirForOrderBy()['col'],getColAndDirForOrderBy()['dir'])->filter()
                ->paginate($length,'*','*',getPageNumber($length));
            return datatable_response($items, null, TripResource::class);
        }
    }
    public function create($id = null)
    {
        $page_title = __('lang.create');
        if (isset($id)) {
            $page_title = __('lang.edit');
            try {
                $item = User::query()->captains()->filter()->findOrFail($id);
            } catch (QueryException $exception) {
                return $this->invalidIntParameter();
            }
        }
        $customers = User::query()->customers()->get();
        $places = User::query()->places()->get();
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => route('captains.index') , 'title' =>'الكباتن','active' => true],
            ['page' => '#' , 'title' =>isset($id)?__('lang.edit'):__('lang.add'),'active' => false],
        ];
        return view('user_management.captains.create', [
            'page_title' =>$page_title,
            'page_breadcrumbs' => $page_breadcrumbs,
            'item' => @$item,
            'customers' => $customers,
            'places' => $places,
        ]);
    }
    public function store(CaptainRequest $request, $id = null)
    {
        $data = $request->only(User::FILLABLE);
        if(isset($data['photo'])){
            $data['photo'] =  uploadFile($request,'user-photos','photo');
        }else{
            unset($data['photo']);
        }
        DB::beginTransaction();
      try {
            $item = User::query()->updateOrCreate([
                'id' => $id,
            ], $data);
            DB::commit();

            return $this->returnBackWithSaveDone();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->returnBackWithSaveDoneFailed();
        }
    }

    public function delete($id){
        try {
            $item = User::query()->captains()->findOrFail($id);
            $item->update([
                'is_deleted' =>!$item->is_deleted
            ]);
            return $this->response_json(true, StatusCodes::OK, 'تم الحذف بنجاح');

        } catch (QueryException $exception) {
            return $this->invalidIntParameter();
        }

    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->get('ids');
        try {
            $result = User::query()->whereIn('id', $ids)->forceDelete();
        } catch (QueryException $exception) {
            return $this->invalidIntParameterJson();
        }


        if($result){
            return $this->response_json(true, StatusCodes::OK, Enum::DELETED_SUCCESSFULLY);

        }
        return $this->response_json(false, StatusCodes::INTERNAL_ERROR, Enum::GENERAL_ERROR);

    }
}
