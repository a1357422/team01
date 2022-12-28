<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbrecord extends Model
{
    use HasFactory;

    protected $fillable=[
        "school_year",
        "semester",
        "sid",
        "bid",
        "floor_head",
        "responsible_floor",
        "created_at",
        "updataed_at",
    ];

    public function scopeSenior($query){
        $query->where("floor_head","=",True);
    }

    public function scopeAllDormits($query)
    {
        $query->select('bid');
        /*  
            SELECT `sbrecords`.`school_year`,`sbrecords`.`semester`,`students`.name,`beds`.`bedcode`
            FROM `sbrecords`
            INNER JOIN `students` ON `sbrecords`.sid=`students`.id
            INNER JOIN `beds` ON `sbrecords`.id = `beds`.id
        */
    }

    public function scopeDormits($query, $did)
    {
        /*  
            SELECT `sbrecords`.`school_year`,`sbrecords`.`semester`,`students`.name,`beds`.`bedcode`
            FROM `sbrecords`
            INNER JOIN `students` ON `sbrecords`.sid=`students`.id
            INNER JOIN `beds` ON `sbrecords`.id = `beds`.id
            WHERE `beds`.did = 4
        */
    }

    public function student(){
        return $this->belongsTo("App\Models\Student","sid","id");
    }
    public function bed(){
        return $this->belongsTo("App\Models\Bed","bid","id");
    }
    public function rollcalls(){
        return $this->hasMany("App\Models\\rollcall","sbid");
    }
    public function leaves(){
        return $this->hasMany("App\Models\leave","sbid");
    }
    public function lates(){
        return $this->hasMany("App\Models\late","sbid");
    }
    public function features(){
        return $this->hasMany("App\Models\\feature","sbid");
    }
    public function delete(){
        $this->rollcalls()->delete();
        $this->leaves()->delete();
        $this->lates()->delete();
        $this->features()->delete();
        
        return parent::delete();
    }
}
