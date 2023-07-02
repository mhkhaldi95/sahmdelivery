<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Constants\Enum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    const FILLABLE = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'username',
        'address',
        'fcm_token',
        'photo',
        'is_deleted',
    ];
    protected $fillable = self::FILLABLE;
    const COL_ORDERS = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $appends = ['photo_path'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
    public function getPhotoPathAttribute(){
        if($this->photo == 'blank.png'){
            return asset('assets/media/avatars/'.$this->photo);
        }
        return asset('storage/user-photos/'.$this->photo);
    }
    public function scopeActive($q){
        return $q->where('is_deleted',0);
    }
    public function scopeCaptains($q){
        return $q->where('role',Enum::CAPTAIN);
    }
    public function scopePlaces($q){
        return $q->where('role',Enum::PLACE);
    }
    public function scopeCustomers($q){
        return $q->where('role',Enum::CUSTOMER);
    }
    public function isAdmin(){
        return in_array($this->role,[Enum::ADMIN,Enum::SUPER_ADMIN]);
    }
    public static function captainReadyForTrips($item = null){
        $today = Carbon::today();

        $captain_ids = Trip::query()->whereNull('amount')->where('status','!=',Enum::CANCELED)
//            ->orWhere(function ($q) use ($today){
//                $q->where('created_at', '<', $today)->where('status', Enum::PENDING);
//            })
            ->pluck('captain_id')
            ->toArray();
        $captain_ids = array_filter($captain_ids, function ($value) {
            return $value !== null;
        });

        $captain_ids = array_values($captain_ids);
        $captain_ids =  array_unique($captain_ids);
        if(isset($item) && !is_null($item->captain_id)){
            $captain_ids = array_diff($captain_ids, [$item->captain_id]);
        }
        return $captain_ids;

    }
    public function scopeFilter($q){
        $col = @request('search')['regex'];
        $value = @request('search')['value'];
        if($value){
            $q->when(true,function ($qq) use ($value){
                $qq->whereRaw("concat(name, ' ',phone) like '%" . $value . "%' ");
            });
        }
        return $q;
    }
}
