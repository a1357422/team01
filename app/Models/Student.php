<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable=[
        "profile_file_path",
        "number",
        "class",
        "name",
        "address",
        "phone",
        "nationality",
        "guardian",
        "salutation",
        "remark",
        "created_at",
        "updataed_at",
    ];

    public function scopeAllClasses($query)
    {
        $query->select('class')->groupBy('class');
    }

    public function scopeClass($query, $class_prefix)
    {
        if($class_prefix == "電")
            $query->where('class', 'like', "%$class_prefix%")->where('class','not like',"%電子%");
        else if($class_prefix == "機")
            $query->where('class', 'like', "%$class_prefix%")->where('class','not like',"%電機%");
        else if($class_prefix == "管")
            $query->where('class', 'like', "%$class_prefix%")->where('class','not like',"%資管%")->where('class','not like',"%企管%");
        else if($class_prefix == "網")
            $query->where('class', 'like', "%$class_prefix%")->where('class','not like',"%專班%");
        else if($class_prefix == "新南向")
            $query->where('class', 'like', "%$class_prefix%")->orWhere('class','=',"1+4");
        else
            $query->where('class', 'like', "%$class_prefix%");
    }

    public function sbrecords(){
        return $this->hasMany("App\Models\Sbrecord","sid");
    }

    public function user(){
        return $this->belongsTo("App\Models\User","id","sid");
    }

    public function delete(){
        $this->sbrecords()->delete();
        $this->user()->delete();
        return parent::delete();
    }
}
