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
        ->join('users','users.sid','=','students.id')
        ->select('sbrecords.id')
        ->where('students.name','=',"$user");
    }

    public function scopeName($query, $name)
    {
        $query->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('sbrecords.id','sbrecords.sid','sbrecords.semester','sbrecords.school_year','sbrecords.floor_head','sbrecords.responsible_floor','beds.bedcode','students.name')
        ->where('students.name','=',"$name");
    }

    public function scopeStudentID($query, $studentID)
    {
        $query->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('sbrecords.id','sbrecords.sid','sbrecords.semester','sbrecords.school_year','beds.bedcode','students.name','sbrecords.floor_head','sbrecords.responsible_floor')
        ->where('students.number','=',"$studentID");
    }

    public function scopeDormitory($query, $did,$floor=null)
    {
        if($floor != null){
            if($floor == 0)
                $floor = "MB";
            $query->join('students','sbrecords.sid','=','students.id')
            ->join('beds','sbrecords.bid','=','beds.id')
            ->select('sbrecords.*','beds.bedcode','students.name')
            ->where('beds.did','=',"$did")
            ->where('bedcode', 'LIKE', "__$floor%");
        }
        else{
            $query->join('students','sbrecords.sid','=','students.id')
            ->join('beds','sbrecords.bid','=','beds.id')
            ->select('sbrecords.*','beds.bedcode','students.name')
            ->where('beds.did','=',"$did");
        }

    }

    public function scopeRoomCode($query, $did=null, $roomcode)
    {
        if ($roomcode == "820")
            $roomcode = "82MB";
        if($did != null){
            $query->join('students','sbrecords.sid','=','students.id')
            ->join('beds','sbrecords.bid','=','beds.id')
            ->select('sbrecords.id','sbrecords.sid','sbrecords.semester','sbrecords.school_year','beds.bedcode','students.name','sbrecords.floor_head','sbrecords.responsible_floor')
            ->where('beds.did','=',"$did")
            ->where('bedcode', 'LIKE', "$roomcode%");
        }
        else{
            $query->join('students','sbrecords.sid','=','students.id')
            ->join('beds','sbrecords.bid','=','beds.id')
            ->select('sbrecords.id','sbrecords.sid','sbrecords.semester','sbrecords.school_year','beds.bedcode','students.name','sbrecords.floor_head','sbrecords.responsible_floor')
            ->where('bedcode', 'LIKE', "$roomcode%");
        }
    }
    public function scopeAllRoom($query)
    {
        $query->join('beds','sbrecords.bid','=','beds.id')
        ->select('beds.bedcode','sbrecords.bid');
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
    public function photos(){
        return $this->hasMany("App\Models\photo","sbid");
    }
    
    public function delete(){
        $this->rollcalls()->delete();
        $this->leaves()->delete();
        $this->lates()->delete();
        $this->photos()->delete();
        
        return parent::delete();
    }
}
