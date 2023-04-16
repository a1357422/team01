<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable=[
        "date",
        "sbid",
        "roomphoto_file_path",
        "upload_file_path",
        "webcam_file_path",
        "created_at",
        "updataed_at",
    ];

    public function scopeFindPhotoSbid($query,$sbid)
    {
        $date=Carbon::now()->toDateString();
        $query->select('photos.date','photos.id','photos.sbid','photos.upload_file_path','photos.webcam_file_path')
        ->where('photos.sbid','=',"$sbid")
        ->where('photos.date','=',"$date");
    }

    public function sbrecord(){
        return $this->belongsTo("App\Models\Sbrecord","sbid","id");
    }

}
