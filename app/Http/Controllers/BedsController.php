<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $dormitories = Bed::allDormitories()->get();
        $data = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $data["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $data["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $data["$dormitory->did"] = "男一宿";
            }
            else{
                $data["$dormitory->did"] = "涵青館";
            }
        }

        return view("beds.index",["beds"=>$beds,'dormitories'=>$data,"showPagination"=>True,'select'=>1]);
    }

    public function api_beds()
    {
        return Bed::all();
    }

    public function api_update(Request $request)
    {
        $bed = Bed::find($request->input('id'));
        if ($bed == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }
        if ($request->input('did') == "涵青館")
            $bed->did = 4;
        else if ($request->input('did') == "男一")
            $bed->did = 3;
        else if ($request->input('did') == "女二")
            $bed->did = 2;
        else
            $bed->did = 1;
        $bed->bedcode = $request->input('bedcode');
        $bed->floor = $request->input('floor');
        $bed->roomtype = $request->input('roomtype');

        if ($bed->save())
        {
            return response()->json([
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'status' => 0,
            ]);
        }
    }

    public function api_delete(Request $request)
    {
        $bed = Bed::find($request->input('id'));

        if ($bed == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($bed->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
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
    

    public function dormitory(Request $request)
    {
        $beds = Bed::dormit($request->input('did'))->get();

        $dormitories = Bed::allDormitories()->get();
        $data = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $data["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $data["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $data["$dormitory->did"] = "男一宿";
            }
            else{
                $data["$dormitory->did"] = "涵青館";
            }
        }

        return view('beds.index', ['beds' => $beds, 'dormitories'=>$data,"showPagination"=>False,'select'=>$request->input('did')]);
    }

    public function create(){
        $dormitories = Dormitory::orderBy('dormitories.id', 'asc')->pluck('dormitories.name', 'dormitories.id');
        return view('beds.create', ['dormitories' => $dormitories,'selectFloor'=>"1F", 'selectRoomType'=>"三人房"]);
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
