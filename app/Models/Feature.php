<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable=[
        "sbid",
        "path",
        "feature",
        "created_at",
        "updataed_at",
    ];

    public function scopeDormitory($query, $did)
    {
        $query->join('sbrecords','features.sbid','=','sbrecords.id')
        ->join('students','sbrecords.sid','=','students.id')
        ->join('beds','sbrecords.bid','=','beds.id')
        ->select('features.id','beds.bedcode','features.path','features.feature')
        ->where('beds.did','=',"$did");
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }
}
