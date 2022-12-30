<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable=[
        "sbid",
        "start",
        "end",
        "reason",
        "floorhead_check",
        "housemaster_check",
        "created_at",
        "updataed_at",
    ];

    public function scopeDormitory($query, $did)
    {
        $query->join('sbrecords','leaves.sbid','=','sbrecords.id')
        ->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('leaves.id','beds.bedcode','leaves.start','leaves.end','leaves.reason','leaves.floorhead_check','leaves.housemaster_check')
        ->where('beds.did','=',"$did");
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }
}
