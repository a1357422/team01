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
        $sbrecords = Sbrecord::paginate(10);
        $dormitories = Bed::allDormitories()->get();
        $bedcodes = Bed::get();
        $roomtags = [];
        $tags = [];
        foreach($bedcodes as $bedcode){
            array_push($roomtags,substr($bedcode->bedcode,0,5));
            $roomtags = array_unique($roomtags);
        }
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
        return view("sbrecords.index",['display'=>1,"sbrecords"=>$sbrecords,'dormitories'=>$tags,"showPagination"=>True,'select' => 1,'roomtags'=>$roomtags]);
    }

    public function senior(){
        $sbrecords = Sbrecord::senior()->get();
        $dormitories = Bed::allDormitories()->get();
        $bedcodes = Bed::get();
        $roomtags = [];
        $tags = [];
        foreach($bedcodes as $bedcode){
            array_push($roomtags,substr($bedcode->bedcode,0,5));
            $roomtags = array_unique($roomtags);
        }
        $tags = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1")
                $tags["$dormitory->did"] = "女一宿";
            else if($dormitory->did == "2")
                $tags["$dormitory->did"] = "女二宿";
            else if($dormitory->did == "3")
                $tags["$dormitory->did"] = "男一宿";
            else
                $tags["$dormitory->did"] = "涵青館";
        }

        return view("sbrecords.index",['display'=>1,"sbrecords"=>$sbrecords,'dormitories'=>$tags,"showPagination"=>False,'select' => 1,'roomtags'=>$roomtags]);
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
        $bedcodes = Bed::get();
        $roomtags = [];
        $tags = [];
        foreach($bedcodes as $bedcode){
            array_push($roomtags,substr($bedcode->bedcode,0,5));
            $roomtags = array_unique($roomtags);
        }
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
        return view("sbrecords.index",['display'=>2,"sbrecords"=>$sbrecords,'dormitories'=>$tags,"showPagination"=>false,'select' => $request->input('dormitory'),'roomtags'=>$roomtags]);
    }

    public function name(Request $request){
        $dormitories = Bed::allDormitories()->get();
        $bedcodes = Bed::get();
        $roomtags = [];
        $tags = [];
        foreach($bedcodes as $bedcode){
            array_push($roomtags,substr($bedcode->bedcode,0,5));
            $roomtags = array_unique($roomtags);
        }
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
        $students = Sbrecord::Name($request->input('name'))->get();
        return view("sbrecords.index",['display'=>1,"sbrecords"=>$students,'dormitories'=>$tags,"showPagination"=>false,'select'=>1,'roomtags'=>$roomtags]);
    }

    public function studentID(Request $request){
        $dormitories = Bed::allDormitories()->get();
        $bedcodes = Bed::get();
        $roomtags = [];
        $tags = [];
        foreach($bedcodes as $bedcode){
            array_push($roomtags,substr($bedcode->bedcode,0,5));
            $roomtags = array_unique($roomtags);
        }
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
        $students = Sbrecord::StudentID($request->input('studentID'))->get();
        return view("sbrecords.index",['display'=>1,"sbrecords"=>$students,'dormitories'=>$tags,"showPagination"=>false,'select'=>1,'roomtags'=>$roomtags]);
    }

    public function roomcode(Request $request){
        $dormitories = Bed::allDormitories()->get();
        $bedcodes = Bed::get();
        $roomtags = [];
        $tags = [];
        foreach($bedcodes as $bedcode){
            array_push($roomtags,substr($bedcode->bedcode,0,5));
            $roomtags = array_unique($roomtags);
        }
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
        $selectroomtags = $request->input('roomcode');
        $students = Sbrecord::RoomCode($roomtags[$request->input('roomcode')])->get();
        return view("sbrecords.index",['display'=>1,"sbrecords"=>$students,'dormitories'=>$tags,"showPagination"=>false,'select'=>1,'roomtags'=>$roomtags,'selectroomtags'=>$selectroomtags]);
    }


    public function create(){
        $students = Student::orderBy('students.id', 'asc')->pluck('students.name', 'students.id');
        $beds = Bed::orderBy('beds.id', 'asc')->pluck('beds.bedcode', 'beds.id');
        return view("sbrecords.create",["students"=>$students,"beds"=>$beds,"selectSemester"=>0,"selectFloor_head"=>0,"selectResponsible_floor"=>""]);
    }
    
    public function store(CreateSbrecordRequest $request){

        $school_year = $request->input('school_year');
        $semester = $request->input('semester');
        $sid = $request->input('sid');
        $bid = $request->input('bid');
        $floor_head = $request->input('floor_head');
        $responsible_floor = $request->input('responsible_floor');
        $sbrecord = Sbrecord::updateOrCreate(['school_year'=>$school_year,'semester'=>$semester,'sid'=>$sid],[
            'school_year' => $school_year,
            'semester' => $semester,
            'sid' => $sid,
            'bid' => $bid,
            'floor_head' => $floor_head,
            'responsible_floor' => $responsible_floor,
        ]);
        if($floor_head == 1){
            $user = User::updateOrCreate(['sid'=>$sid],[
                'role'=> 'floorhead'
            ]);
        }
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

        return view('sbrecords.edit',['sbrecord'=>$sbrecord,"students"=>$students,"beds"=>$beds, "selectSemester"=>$selectSemester, 'selectName'=>$selectName,'selectBedcode'=>$selectBedcode, "selectFloor_head"=>$selectFloor_head, "selectResponsible_floor"=>$selectResponsible_floor]);
    }
    public function update($id,CreateSbrecordRequest $request){
        $sbrecord = Sbrecord::findOrFail($id);

        $sbrecord->school_year = $request->input('school_year');
        $sbrecord->semester = $request->input('semester');
        $sbrecord->sid = $request->input('sid');
        $sbrecord->bid = $request->input('bid');
        $sbrecord->floor_head = $request->input('floor_head');
        $sbrecord->responsible_floor = $request->input('responsible_floor');
        if($sbrecord->floor_head == 1){
            $user = User::updateOrCreate(['sid'=>$sbrecord->sid],[
                'role'=> 'floorhead'
            ]);
        }
        else{
            $user = User::updateOrCreate(['sid'=>$sbrecord->sid],[
                'role'=> 'user'
            ]);
        }
        $sbrecord->save();
        return redirect('sbrecords');
    }
}
