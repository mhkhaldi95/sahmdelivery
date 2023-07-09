<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartEndTime extends Model
{
    use HasFactory;
    const FILLABLE = ['start_time','end_time','ids_trips'];
    protected $casts = ['ids_trips'=>'array'];
    protected $fillable = self::FILLABLE;


    public function scopeFilter($q){

        if(request('datefilter') && !empty(request('datefilter'))){
            $q->where('completed_at','>=', convetDate(explodeDate()[0]). ' 00:00:00')
                ->where('completed_at','<=', convetDate(explodeDate()[1]). ' 23:59:59')
            ;
        }
        return $q;
    }

}
