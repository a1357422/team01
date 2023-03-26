<?php

namespace App\Http\Controllers;

// use Request;
use App\Http\Requests\CreateSbrecordRequest;
use App\Models\Sbrecord;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Http\Request;

class SbrecordsController extends Controller
{
    //
    public function index(){
        // $sbrecords = Sbrecord::senior()->get();
        // $users = User::get();
        // foreach($sbrecords as $sbrecord){
        //     if($sbrecord->floor_head){
                
        //     }
        // }
        $sbrecords = Sbrecord::paginate(10);
        $dormitories = Bed::allDormitories()->get();
        
        $tags = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $tags["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $tags["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $tags["$dormitory->did"] = "男一宿";
            }
            else{
                $tags["$dormitory->did"] = "涵青館";
            }
        }
        return view("sbrecords.index",['display'=>1,"sbrecords"=>$sbrecords,'dormitories'=>$tags,"showPagination"=>True,'select' => 1]);
    }

    public function api_sbrecords()
    {
        return Sbrecord::all();
    }

    public function api_update(Request $request)
    {
        $sbrecord = Sbrecord::find($request->input('id'));
        if ($sbrecord == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }
        
        $sbrecord->school_year = $request->input('school_year');
        $sbrecord->semester = $request->input('semester');
        $sbrecord->sid = $request->input('sid');
        $sbrecord->bid = $request->input('bid');
        $sbrecord->floor_head = $request->input('floor_head');
        $sbrecord->responsible_floor = $request->input('responsible_floor');

        if ($sbrecord->save())
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
        $sbrecord = Sbrecord::find($request->input('id'));

        if ($sbrecord == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($sbrecord->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
    }

    public function senior(){
        $sbrecords = Sbrecord::senior()->get();
        $dormitories = Bed::allDormitories()->get();
        
        $tags = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $tags["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $tags["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $tags["$dormitory->did"] = "男一宿";
            }
            else{
                $tags["$dormitory->did"] = "涵青館";
            }
        }

        return view("sbrecords.index",['display'=>1,"sbrecords"=>$sbrecords,'dormitories'=>$tags,"showPagination"=>False,'select' => 1]);
    }

    public function show($id){
        $sbrecord = Sbrecord::findOrFail($id);
        $rollcalls = $sbrecord->rollcalls;
        $leaves = $sbrecord->leaves;
        $lates = $sbrecord->lates;

        return view("sbrecords.show",["sbrecord"=>$sbrecord, "rollcalls"=>$rollcalls, "leaves"=>$leaves, "lates"=>$lates]);
    }

    public function destroy($id){
        $sbrecord = Sbrecord::findOrFail($id);
        $sbrecord->delete();
        return redirect("sbrecords");
    }

    public function dormitory(Request $request)
    {
        $sbrecords = Sbrecord::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
        $tags = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $tags["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $tags["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $tags["$dormitory->did"] = "男一宿";
            }
            else{
                $tags["$dormitory->did"] = "涵青館";
            }
        }
        return view("sbrecords.index",['display'=>2,"sbrecords"=>$sbrecords,'dormitories'=>$tags,"showPagination"=>false,'select' => $request->input('dormitory')]);
    }

    public function create(){
        $students = Student::orderBy('students.id', 'asc')->pluck('students.name', 'students.id');
        $beds = Bed::orderBy('beds.id', 'asc')->pluck('beds.bedcode', 'beds.id');
        return view("sbrecords.create",["students"=>$students,"beds"=>$beds]);
    }
    
    public function store(CreateSbrecordRequest $request){

        $school_year = $request->input('school_year');
        $semester = $request->input('semester');
        $sid = $request->input('sid');
        $bid = $request->input('bid');
        $floor_head = $request->input('floor_head');
        $responsible_floor = $request->input('responsible_floor');

        $sbrecord = Sbrecord::create([
            'school_year' => $school_year,
            'semester' => $semester,
            'sid' => $sid,
            'bid' => $bid,
            'floor_head' => $floor_head,
            'responsible_floor' => $responsible_floor,

        ]);
        return redirect("sbrecords");
    }
    public function edit($id){
        $sbrecord = Sbrecord::findOrFail($id);
        $students = Student::orderBy('students.id', 'asc')->pluck('students.name', 'students.id');
        $beds = Bed::orderBy('beds.id', 'asc')->pluck('beds.bedcode', 'beds.id');
        $selectSemester = $sbrecord->semester;
        $selectName = $sbrecord->sid;
        $selectBedcode = $sbrecord->bid;
        $selectFloor_head = $sbrecord->floor_head;
        $selectResponsible_floor = $sbrecord->responsible_floor;

        return view('sbrecords.edit',['sbrecord'=>$sbrecord,"students"=>$students,"beds"=>$beds, "selectsemester"=>$selectSemester, 'selectName'=>$selectName,'selectBedcode'=>$selectBedcode, "selectFloor_head"=>$selectFloor_head, "selectResponsible_floor"=>$selectResponsible_floor]);
    }
    public function update($id,CreateSbrecordRequest $request){
        $sbrecord = Sbrecord::findOrFail($id);

        $sbrecord->school_year = $request->input('school_year');
        $sbrecord->semester = $request->input('semester');
        $sbrecord->sid = $request->input('sid');
        $sbrecord->bid = $request->input('bid');
        $sbrecord->floor_head = $request->input('floor_head');
        $sbrecord->responsible_floor = $request->input('responsible_floor');

        $sbrecord->save();
        return redirect('sbrecords');
    }
}
