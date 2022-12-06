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
        $dormitories = Dormitory::orderBy('dormitories.id', 'asc')->pluck('dormitories.name', 'dormitories.id');
        return view('beds.create', ['dormitories' => $dormitories]);
    }

    public function store(){
        $input = Request::all();
        Bed::create($input);
        return redirect("beds");
    }

    public function edit($id){
        $bed = Bed::findOrFail($id);
        $dormitories = Dormitory::orderBy('dormitories.id', 'asc')->pluck('dormitories.name', 'dormitories.id');
        $selectDid = $bed->did;
        $selectFloor = $bed->floor;
        $selectRoomType = $bed->roomtype;
        return view('beds.edit', ['bed'=>$bed, 'dormitories'=>$dormitories, 'selectDid'=>$selectDid, 'selectFloor'=>$selectFloor, 'selectRoomType'=>$selectRoomType]);
    }
    public function update($id){
        $input = Request::all();
        $bed = Bed::findOrFail($id);

        $bed->bedcode = $input['bedcode'];
        $bed->did = $input['did'];
        $bed->floor = $input['floor'];
        $bed->roomtype = $input['roomtype'];

        $bed->save();
        return redirect('beds');
    }
}
