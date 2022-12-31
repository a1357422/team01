<?php

namespace App\Http\Controllers;

use App\Models\Leave;
// use Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;
use App\Models\Bed;
use App\Http\Requests\CreateLeaveRequest;
use Illuminate\Http\Request;

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
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        return view("leaves.create",["sbrecords"=>$sbrecords]);
    }
    public function store(CreateLeaveRequest $request){
        $sbid = $request->input('sbid');
        $start = $request->input('start');
        $end = $request->input('end');
        $reason = $request->input('reason');
        
        $leave = Leave::create([
            'sbid' => $sbid,
            'start' => $start,
            'end' => $end,
            'reason' => $reason,
        ]);
        return redirect("leaves");
    }
    public function edit($id){
        $leave = Leave::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        $selectSbid = $leave->sbid;
        return view('leaves.edit',['leave'=>$leave,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid]);
    }
    public function update($id,CreateLeaveRequest $request){
        $leave = Leave::findOrFail($id);

        $leave->sbid = $request->input('sbid');
        $leave->start = $request->input('start');
        $leave->end = $request->input('end');
        $leave->reason = $request->input('reason');

        $leave->save();
        return redirect('leaves');
    }
}