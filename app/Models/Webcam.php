<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webcam extends Model
{
    use HasFactory;

    protected $fillable=[
        "sbid",
        "file_path",
        "created_at",
        "updataed_at",
    ];

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }

}
