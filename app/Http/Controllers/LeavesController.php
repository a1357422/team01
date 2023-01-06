<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;
use App\Models\Bed;
use App\Http\Requests\CreateLeaveRequest;
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

    public function api_leaves()
    {
        return Leave::all();
    }

    public function api_update(Request $request)
    {
        $leave = Leave::find($request->input('id'));
        if ($leave == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }
        
        $leave->start = $request->input('start');
        $leave->end = $request->input('end');
        $leave->reason = $request->input('reason');

        if ($leave->save())
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
        $leave = Leave::find($request->input('id'));

        if ($leave == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($leave->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
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
        return redirect("leaves");
    }
    public function edit($id){
        $leave = Leave::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');
        $selectFloorhead_check = $leave->floorhead_check;
        $selectHousemaster_check = $leave->housemaster_check;

        return view('leaves.edit',['leave'=>$leave,'sbrecords'=>$sbrecords,'selectFloorhead_Check'=>$selectFloorhead_check,'selectHousemaster_Check'=>$selectHousemaster_check]);
    }
    public function update($id,Request $request){
        $leave = Leave::findOrFail($id);

        $leave->floorhead_check = $request->input('floorhead_check');
        $leave->housemaster_check = $request->input('housemaster_check');

        $leave->save();
        return redirect('leaves');
    }
}