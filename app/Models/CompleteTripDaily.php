<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteTripDaily extends Model
{
    use HasFactory;
    const FILLABLE = ['fix_amount','ratio','total_amount','captain_id','total_amount_for_captain','ids_trips','total_amount_for_office','completed_at'];
    protected $casts = ['ids_trips'=>'array'];
    protected $fillable = self::FILLABLE;
    public function trips(){
        return $this->hasMany(Trip::class);
    }
    public function scopeFilter($q){
        if(request('captain_id') && !empty(request('captain_id'))){
            $q->where('captain_id', request('captain_id'));
        }
        if(request('datefilter') && !empty(request('datefilter'))){
            $q->where('completed_at','>=', convetDate(explodeDate()[0]). ' 00:00:00')
                ->where('completed_at','<=', convetDate(explodeDate()[1]). ' 23:59:59')
            ;
        }
        return $q;
    }
}
