<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable=[
        "sbid",
        "upload_file_path",
        "webcam_file_path",
        "created_at",
        "updataed_at",
    ];

    public function scopeFindPhotoSbid($query,$sbid)
    {
        $query->select('photos.sbid','photos.upload_file_path','photos.webcam_file_path')->where('photos.sbid','=',"$sbid");
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }

}
