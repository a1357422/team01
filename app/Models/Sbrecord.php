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

    public function scopeUser($query, $user)
    {
        $query->join('students','sbrecords.sid','=','students.id')
        ->join('users','students.name','=','users.name')
        ->select('sbrecords.id')
        ->where('students.name','=',"$user");
    }

    public function scopeDormitory($query, $did,$floor=null)
    {
        $query->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('sbrecords.id','sbrecords.school_year','sbrecords.semester','students.name','beds.bedcode')
        ->where('beds.did','=',"$did")
        ->where('bedcode', 'LIKE', "__$floor%");
    }

    public function scopeSchool_year($query, $school_year=111,$semester=2)
    {
        $query->select('sbrecords.id','sbrecords.school_year','sbrecords.semester')
        ->where('sbrecords.school_year','=',"$school_year")
        ->where('sbrecords.semester', '=', "$semester");
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
