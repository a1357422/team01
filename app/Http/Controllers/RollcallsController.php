<?php

namespace App\Http\Controllers;

use App\Models\Rollcall;
// use Request
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;
use App\Http\Requests\CreateRollcallRequest;
use App\Models\Bed;
use Illuminate\Http\Request;

class RollcallsController extends Controller
{
    //
    public function index(){
        $rollcalls = Rollcall::paginate(10);
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

        return view("rollcalls.index",['display'=>1,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>True,'select'=>1]);
    }

    public function show($id){
        $rollcall = Rollcall::findOrFail($id);
        return view("rollcalls.show",["rollcall"=>$rollcall]);
    }

    public function destroy($id){
        $rollcall = Rollcall::findOrFail($id);
        $rollcall->delete();
        return redirect("rollcalls");
    }

    public function dormitory(Request $request)
    {
        $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->get();
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
        return view("rollcalls.index",['display'=>2,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>false,'select'=>$request->input('dormitory')]);
    }

    public function create(){
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');
        return view("rollcalls.create",['sbrecords'=>$sbrecords]);
    }
    public function store(CreateRollcallRequest $request){
        $date = $request->input('date');
        $sbid = $request->input('sbid');
        $presence = $request->input('presence');
        $leave = $request->input('leave');
        $late = $request->input('late');

        $rollcall = Rollcall::create([
            'date' => $date,
            'sbid' => $sbid,
            'presence' => $presence,
            'leave' => $leave,
            'late' => $late,
        ]);

        return redirect("rollcalls");
    }
    public function edit($id){
        $rollcall = Rollcall::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        $selectSbid = $rollcall->sbid;
        $selectPresence = $rollcall->presence;
        $selectLeave = $rollcall->leave;
        $selectLate = $rollcall->late;
        return view('rollcalls.edit',['rollcall'=>$rollcall,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid,'selectPresence'=>$selectPresence,'selectLeave'=>$selectLeave,'selectLate'=>$selectLate]);
    }
    public function update($id,CreateRollcallRequest $request){
        $rollcall = Rollcall::findOrFail($id);

        $rollcall->date = $request->input('date');
        $rollcall->sbid = $request->input('sbid');
        $rollcall->presence = $request->input('presence');
        $rollcall->leave = $request->input('leave');
        $rollcall->late = $request->input('late');

        $rollcall->save();
        return redirect('rollcalls');
    }
}
