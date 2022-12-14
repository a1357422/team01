<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bed extends Model
{
    use HasFactory;

    protected $fillable=[
        "bedcode",
        "did",
        "floor",
        "roomtype",
        "created_at",
        "updataed_at",
    ];

    public function dormitory(){
        return $this->belongsTo("App\Models\Dormitory","did","id");
    }

    public function sbrecords(){
        return $this->hasMany("App\Models\sbrecord","bid");
    }

    public function delete(){
        $sbrecords = $this->sbrecords()->get();
        foreach ($sbrecords as $sbrecord)
            {
                DB::table('rollcalls')->where('sbid', $sbrecord->id)->delete();
                DB::table('lates')->where('sbid', $sbrecord->id)->delete();
                DB::table('leaves')->where('sbid', $sbrecord->id)->delete();
                DB::table('features')->where('sbid', $sbrecord->id)->delete();
            }
        $this->sbrecords()->delete();
        return parent::delete();
    }
}
