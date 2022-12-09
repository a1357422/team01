<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Dormitory;
use Illuminate\Support\Facades\DB;
// use Request;
use App\Http\Requests\CreateBedRequest;

class BedsController extends Controller
{
    //
    public function index(){
        $beds = Bed::paginate(10);
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

    public function store(CreateBedRequest $request){
        $bedcode = $request->input('bedcode');
        $did = $request->input('did');
        $floor = $request->input('floor');
        $roomtype = $request->input('roomtype');

        $bed = Bed::create([
            'bedcode' => $bedcode,
            'did' => $did,
            'floor' => $floor,
            'roomtype' => $roomtype
        ]);
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
    public function update($id,CreateBedRequest $request){
        $bed = Bed::findOrFail($id);

        $bed->bedcode = $request->input('bedcode');
        $bed->did = $request->input('did');
        $bed->floor = $request->input('floor');
        $bed->roomtype = $request->input('roomtype');

        $bed->save();
        return redirect('beds');
    }
}
