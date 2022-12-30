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

    public function scopeDormit($query, $did)
    {
        $query->join('sbrecords','rollcalls.sbid','=','sbrecords.id')
        ->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('rollcalls.id','rollcalls.date','sbrecords.semester','beds.bedcode','rollcalls.presence','rollcalls.leave','rollcalls.late')
        ->where('beds.did','=',"$did");
        
    //     SELECT `rollcalls`.id , `rollcalls`.date,`rollcalls`.sbid,`rollcalls`.presence,`rollcalls`.leave,`rollcalls`.late,
	// 	`sbrecords`.id,`beds`.`bedcode`
    //         FROM `rollcalls`
    //         INNER JOIN `sbrecords` ON `rollcalls`.sbid = `sbrecords`.id
    //         INNER JOIN `students` ON `sbrecords`.sid=`students`.id
    //         INNER JOIN `beds` ON `sbrecords`.bid = `beds`.id
            
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }

}
