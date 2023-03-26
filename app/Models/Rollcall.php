<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rollcall extends Model
{
    use HasFactory;

    protected $fillable=[
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
        ->select('rollcalls.id','rollcalls.date','sbrecords.semester','beds.bedcode','rollcalls.presence','rollcalls.leave','rollcalls.late','students.name')
        ->where('beds.did','=',"$did");
    }

    public function scopePresence($query)
    {
        $query->select('*')->where('rollcalls.presence','=',0);
    }

    public function scopeFindRollcallSbid($query,$sbid)
    {
        $query->select('rollcalls.id','rollcalls.sbid')->where('rollcalls.sbid','=',"$sbid");
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }

}
