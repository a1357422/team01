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

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }
}
