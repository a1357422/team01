<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Late extends Model
{
    use HasFactory;
    
    protected $fillable=[
        "sbid",
        "start",
        "end",
        "reason",
        "company",
        "contact",
        "address",
        "back_time",
        "filename_path",
        "floorhead_check",
        "chief_check",
        "housemaster_check",
        "admin_check",
        "created_at",
        "updataed_at",
    ];

    public function scopeDormitory($query, $did)
    {
        $query->join('sbrecords','lates.sbid','=','sbrecords.id')
        ->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('lates.id','beds.bedcode','lates.start','lates.end','lates.reason','lates.company','lates.contact','lates.address'
                ,'lates.back_time','lates.filename_path','lates.floorhead_check','lates.chief_check','lates.housemaster_check','lates.admin_check')
        ->where('beds.did','=',"$did");

        // SELECT `lates`.id , `lates`.sbid,`lates`.start,`lates`.end,`lates`.reason,
		// `lates`.company,`lates`.contact,`lates`.address,`lates`.back_time,`lates`.filename_path,
        // `lates`.floorhead_check,`lates`.chief_check,`lates`.housemaster_check,`lates`.admin_check,
		// `sbrecords`.id,`beds`.`bedcode`
		// FROM `lates`
		// INNER JOIN `sbrecords` ON `lates`.sbid = `sbrecords`.id
		// INNER JOIN `students` ON `sbrecords`.sid=`students`.id
		// INNER JOIN `beds` ON `sbrecords`.bid = `beds`.id
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }
}
