<?php

namespace App\Models;

use App\Constants\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    const FILLABLE = ['captain_id','owner_id','type','come_at','complete_trip_daily_id','is_owner_place','from','to','amount','payment_type','customer_paid','place_paid','status','fix_amount','ratio'];
    protected $fillable = self::FILLABLE;

    public function captain(){
        return $this->belongsTo(User::class,'captain_id','id');
    }
    public function owner(){
        return $this->belongsTo(User::class,'owner_id','id');
    }

    public function scopeFilter($q)
    {

        $searchParams = [];
        if(request('search') && !is_null(request('search')['value'])){
            $searchParams = json_decode(request('search')['value'], true);
        }

        foreach ($searchParams as $column => $value) {
            if ($value !== '') {
                switch ($column) {
                    case 'customer_id':
                    case 'place_id':
                        $q->where('owner_id', $value);
                        break;
                    case 'captain_id':
                        $q->where('captain_id', $value);
                        break;
                    case 'status':
                        $q->where('status', $value);
                        break;
                    case 'date_from':
                        $q->where('created_at','>=', $value.':00');
                        break;
                    case 'date_to':
                        $q->where('created_at', '<=',$value.':00');
                        break;
                    case 'open_close':
                        if($value == 'open'){
                            $q->whereNull('amount');
                        }
                        if($value == 'closed'){
                            $q->whereNotNull('amount');
                        }

                        break;
                    // Add additional cases for other columns if needed
                }
            }
        }

        if(request('captain_id') && !empty(request('captain_id'))){
            $q->where('captain_id', request('captain_id'));
        }
        if(request('datefilter') && !empty(request('datefilter'))){
            $q->where('created_at','>=', $this->convetDate(explodeDate()[0]). ' 00:00:00')
                ->where('created_at','<=', $this->convetDate(explodeDate()[1]). ' 23:59:59')
            ;
        }
        return $q;
    }

    public function scopeNotClosed($q){
        $q->whereNull('amount')->whereNotIn('status',[Enum::CANCELED,Enum::COMPLETED]);
    }
    public function scopeCompleted($q){
        $q->where('status',Enum::COMPLETED);
    }
    public function scopeClosed($q){
        $q->whereNotNull('amount');
    }
    public function scopePending($q){
        $q->where('status',Enum::PENDING);
    }

    public function scopePlaceTrips($q){
        $q->where('owner_id',auth()->user()->id);
    }
    public function convetDate($dateString){
        $date = \DateTime::createFromFormat('m/d/Y', $dateString);
        $formattedDate = $date->format('Y/m/d');
        return $formattedDate;
    }
    public function getType(){
        if($this->payment_type == Enum::IMMEDIATELY){
            return 'فوري';
        }else{
            return 'آجل';
        }
    }
}
