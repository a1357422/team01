<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;
use App\Models\Bed;
use App\Http\Requests\CreateLeaveRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    //
    public function index(){
        $leaves = Leave::paginate(10);
        $all_leaves = Leave::get();
        $dormitories = Bed::allDormitories()->get();
        
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

        return view("leaves.index",['display'=>1,"leaves"=>$leaves,'all_leaves'=>$all_leaves,'dormitories'=>$tags,"showPagination"=>True,'select'=>1]);
    }

    public function show($id){
        $leave = Leave::findOrFail($id);
        return view('leaves.show', ['leave' => $leave]);
    }

    public function dormitory(Request $request)
    {
        $leaves = Leave::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
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
        return view("leaves.index",['display'=>2,"leaves"=>$leaves,'dormitories'=>$tags,"showPagination"=>false,'select'=>$request->input('dormitory')]);
    }

    public function examine($id){
        $leave = Leave::findOrFail($id);

        return view('leaves.examine', ['leave' => $leave]);
    }

    public function destroy($id){
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return redirect('leaves');
    }
    public function create(){
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');
        $students = Student::orderBy('students.id','asc')->get();
        $tags = [];
        foreach($students as $student){
            array_push($tags,$student->name);
        }
        $tags = array_unique($tags);
        return view("leaves.create",["sbrecords"=>$sbrecords,"tags"=>$tags]);
    }
    public function store(CreateLeaveRequest $request){
        if(Sbrecord::User(Auth::user()->name)->first() != null){
            $user_sbids = Sbrecord::User(Auth::user()->name)->get();
            foreach($user_sbids as $user_sbid){
                $sbid = $user_sbid->id;
            }
            $start = $request->input('start');
            $end = $request->input('end');
            $reason = $request->input('reason');
            
            $leave = Leave::create([
                'sbid' => $sbid,
                'start' => $start,
                'end' => $end,
                'reason' => $reason,
            ]);
        }
        else{
            $student = Student::findOrFail($request->input('name')+1);
            $user_sbids = Sbrecord::Where('sid',$student->id)->get();
            foreach($user_sbids as $user_sbid){
                $sbid = $user_sbid->id;
            }
            $start = $request->input('start');
            $end = $request->input('end');
            $reason = $request->input('reason');
            
            $leave = Leave::create([
                'sbid' => $sbid,
                'start' => $start,
                'end' => $end,
                'reason' => $reason,
            ]);
        }
        return redirect("leaves");
    }
    public function edit($id){
        $leave = Leave::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');
        $selectFloorhead_check = $leave->floorhead_check;
        $selectHousemaster_check = $leave->housemaster_check;

        return view('leaves.edit',['leave'=>$leave,'sbrecords'=>$sbrecords,'selectFloorhead_check'=>$selectFloorhead_check,'selectHousemaster_check'=>$selectHousemaster_check]);
    }
    public function update($id,Request $request){
        $leave = Leave::findOrFail($id);

        $leave->floorhead_check = $request->input('floorhead_check');
        $leave->housemaster_check = $request->input('housemaster_check');

        $leave->save();
        return redirect('leaves');
    }
}