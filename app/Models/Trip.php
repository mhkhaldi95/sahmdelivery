<?php

namespace App\Models;

use App\Constants\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    const FILLABLE = ['captain_id','owner_id','type','come_at','complete_trip_daily_id','is_owner_place','from','to','amount','payment_type','customer_paid','place_paid','status'];
    protected $fillable = self::FILLABLE;

    public function captain(){
        return $this->belongsTo(User::class,'captain_id','id');
    }
    public function completeTripDaily(){
        return $this->belongsTo(CompleteTripDaily::class,'complete_trip_daily_id','id');
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
                    case 'date':
                        $q->whereDate('created_at', $this->convetDate($value));
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
    public function scopeFilterPrint($q)
    {

        if((request('customer_filter') && !empty(request('customer_filter')))){
            $q->where('owner_id', request('customer_filter'));
        }

        if((request('place_filter') && !empty(request('place_filter')))){
            $q->where('owner_id', request('place_filter'));
        }

        if((request('status_filter') && !empty(request('status_filter')))){
            $q->where('status', request('status_filter'));
        }
        if((request('captain_filter') && !empty(request('captain_filter')))){
            $q->where('captain_id', request('captain_filter'));
        }
        if((request('open_close_filter') && !empty(request('open_close_filter')))){
            if( request('open_close_filter') == 'open'){
                $q->whereNull('amount');
            }
            if(request('open_close_filter') == 'closed'){
                $q->whereNotNull('amount');
            }
        }

//        if((request('date') && !empty(request('date')))){
//            $q->whereDate('created_at',  request('date'));
//        }
//
        if((request('date_from') && !empty(request('date_from')))){
            $q->where('created_at','>=', request('date_from').':00');
        }
        if((request('date_to') && !empty(request('date_to')))){
            $q->where('created_at', '<=',request('date_to').':00');
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
    public function scopeCancel($q){
        $q->where('status',Enum::CANCELED);
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
