<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $this->beds()->delete();
        return parent::delete();
    }
}
