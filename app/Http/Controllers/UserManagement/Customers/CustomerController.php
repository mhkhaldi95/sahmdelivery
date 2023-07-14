<?php

namespace App\Http\Controllers\UserManagement\Customers;

use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\Customers\CustomerRequest;
use App\Http\Resources\Trips\TripResource;
use App\Http\Resources\UserManagement\Customers\CustomerResource;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function index(Request $request){
        if($request->ajax()){
            $length = \request()->get('length', 10);
            $items = User::query()->orderByDesc('id')->customers()->filter()->paginate(\request()->get('length', 10),'*','*',getPageNumber($length));
            return datatable_response($items, null, CustomerResource::class);
        }
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'الزبائن','active' => false],
        ];
        return view('user_management.customers.index', [
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
            $items = Trip::query()->where('owner_id',$id)->with(['captain','owner'])->orderBy(getColAndDirForOrderBy()['col'],getColAndDirForOrderBy()['dir'])->filter()
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
                $item = User::query()->customers()->filter()->findOrFail($id);
            } catch (QueryException $exception) {
                return $this->invalidIntParameter();
            }
        }
        $page_breadcrumbs = [
            ['page' => route('dashboard.index') , 'title' =>'الرئيسية','active' => true],
            ['page' => route('customers.index') , 'title' =>'الزبائن','active' => true],
            ['page' => '#' , 'title' =>isset($id)?__('lang.edit'):__('lang.add'),'active' => false],
        ];
        $places = User::query()->places()->get();
        $captains = User::query()->captains()->get();
        return view('user_management.customers.create', [
            'page_title' =>$page_title,
            'page_breadcrumbs' => $page_breadcrumbs,
            'item' => @$item,
            'captains' => $captains,
            'places' => $places,
        ]);
    }
    public function store(CustomerRequest $request, $id = null)
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
            $item = User::query()->customers()->findOrFail($id);
            $item->update([
                'is_deleted' =>!$item->is_deleted
            ]);
            return $this->response_json(true, StatusCodes::OK, 'تم الحذف بنجاح');
        } catch (QueryException $exception) {
            return $this->invalidIntParameter();
        }


    }

}
