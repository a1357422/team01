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


    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }
}
