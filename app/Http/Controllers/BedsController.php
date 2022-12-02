<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Dormitory;
use Illuminate\Support\Facades\DB;
use Request;

class BedsController extends Controller
{
    //
    public function index(){
        $beds = Bed::all();
        return view("beds.index",["beds"=>$beds]);
    }

    public function show($id){
        $bed = Bed::findOrFail($id);
        return view("beds.show",["bed"=>$bed]);
    }

    public function destroy($id){
        $bed = Bed::findOrFail($id);
        $bed->delete();
        return redirect("beds");
    }
    
    public function create(){
        $dormitory = Dormitory::orderBy('dormitories.id', 'asc')->pluck('dormitories.name', 'dormitories.id');
        return view('beds.create', ['dormitories' => $dormitory]);
    }

    public function store(){
        $input = Request::all();
        Bed::create($input);
        return redirect("beds");
    }

    public function edit($id){
        $bed = Bed::findOrFail($id);
        $dormitory = Dormitory::orderBy('dormitories.id', 'asc')->pluck('dormitories.name', 'dormitories.id');
        $selectDid = $bed->did;
        return view('beds.edit', ['bed'=>$bed, 'dormitories'=>$dormitory, 'selectDid'=>$selectDid]);
    }
}
