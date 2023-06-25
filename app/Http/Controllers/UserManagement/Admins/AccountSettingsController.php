<?php

namespace App\Http\Controllers\UserManagement\Admins;

use App\Constants\Enum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountSettingsController extends Controller
{
    public function __construct()
    {
    }
    public function create($id){
        $page_title = 'اعدادات الحساب';
        try {
            $item = User::query()->findOrFail($id);
        } catch (QueryException $exception) {
            return $this->invalidIntParameter();
        }

        $dashboard_url = route('dashboard.index');
        if(\auth()->user()->role == Enum::PLACE){
            $dashboard_url = route('places.dashboard.index');
        }
        $page_breadcrumbs = [
            ['page' => $dashboard_url , 'title' =>'الرئيسية','active' => true],
            ['page' => '#' , 'title' =>'اعدادات الحساب','active' => false],
        ];
        return view('user_management.account', [
            'page_title' =>$page_title,
            'page_breadcrumbs' => $page_breadcrumbs,
            'item' => @$item,
        ]);
    }
    public function updateInfo(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        $data['name'] = $request->name;
        $data['address'] = $request->address??null;
        if($request->photo){
            $data['photo'] =  uploadFile($request,'user-photos','photo');
        }
        $item = User::query()->updateOrCreate([
            'id' => Auth::id()
        ],$data);



        return $this->returnBackWithSaveDone();

    }
    public function updateUsername(Request $request){
        $request->validate([
            'username' => 'required|unique:users,username,' . Auth::id(). '|regex:/^[A-Za-z0-9]+$/',
            'confirmemailpassword' => 'required|string|max:255',
        ],[
          'confirmemailpassword.required'  =>' كلمة المرور مطلوب'
        ]);
        $data['username'] = $request->username;
        if (Hash::check($request->confirmemailpassword, auth()->user()->password)) {
            User::query()->updateOrCreate([
                'id' => Auth::id()
            ],$data);
            return $this->returnBackWithSaveDone();
        }
        return $this->returnBackWithSaveDoneFailed();

    }
    public function updatePassword(Request $request){
        $request->validate([
            'currentpassword' => 'required|string|max:255',
            'password' => 'required|min:3|confirmed',
        ]);
        $data['password'] = Hash::make($request->password);
        if (Hash::check($request->currentpassword, auth()->user()->password)) {
            User::query()->updateOrCreate([
                'id' => Auth::id()
            ],$data);
            return $this->returnBackWithSaveDone();
        }
        return $this->returnBackWithSaveDoneFailed();
    }
}
