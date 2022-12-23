<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable=[
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
        // $query->select('class')->groupBy('class');
        $query->select('class')->groupBy('class');
        //select SUBSTR(class,1,2) from students
    }

    public function scopeClass($query, $class_prefix)
    {
        // dd($class);
        // $query->where('class','=', $class);
        $query->where('class', 'like', "$class_prefix%");
    }

    public function sbrecords(){
        return $this->hasMany("App\Models\Sbrecord","sid");
    }

    public function delete(){
        $this->sbrecords()->delete();
        return parent::delete();
    }
}
