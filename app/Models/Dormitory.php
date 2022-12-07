<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable=[
        "name",
        "housemaster",
        "contact",
        "created_at",
        "updataed_at",
    ];
    
    public function beds(){
        return $this->hasMany("App\Models\Bed","did");
    }

    

    public function delete(){
        $beds = $this->beds()->get();
        foreach ($beds as $bed){
            $sbrecords = DB::table('sbrecords')->where('bid',$bed->id)->get();
            foreach ($sbrecords as $sbrecord)
            {
                DB::table('rollcalls')->where('sbid', $sbrecord->id)->delete();
                DB::table('lates')->where('sbid', $sbrecord->id)->delete();
                DB::table('leaves')->where('sbid', $sbrecord->id)->delete();
                DB::table('features')->where('sbid', $sbrecord->id)->delete();
            }
            DB::table('sbrecords')->where('bid',$bed->id)->delete();
        }
        $this->beds()->delete();
        return parent::delete();
    }
}
