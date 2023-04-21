<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rollcall extends Model
{
    use HasFactory;

    protected $fillable=[
        "rollcaller",
        "date",
        "sbid",
        "presence",
        "leave",
        "late",
        "created_at",
        "updataed_at",
    ];

    public function scopeDormitory($query, $did)
    {
        $query->join('sbrecords','rollcalls.sbid','=','sbrecords.id')
        ->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('rollcalls.id','rollcalls.date','sbrecords.semester','beds.bedcode','rollcalls.presence','rollcalls.leave','rollcalls.late','rollcalls.identify','students.name')
        ->where('beds.did','=',"$did");
    }

    public function scopePresence($query)
    {
        $query->select('*')->where('rollcalls.presence','=',0);
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }

}
