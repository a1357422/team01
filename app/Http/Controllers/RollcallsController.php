<?php

namespace App\Http\Controllers;

use App\Models\Rollcall;
// use Request
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;
use App\Http\Requests\CreateRollcallRequest;
use App\Models\Bed;
use App\Models\Dormitory;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RollcallsController extends Controller
{
    //
    public function index(){
        $rollcalls = Rollcall::orderBy('id','ASC')->paginate(10);
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

    public function api_rollcalls()
    {
        return Rollcall::all();
    }

    public function api_update(Request $request)
    {
        $rollcall = Rollcall::find($request->input('id'));
        if ($rollcall == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }
        
        $rollcall->date = $request->input('date');
        $rollcall->sbid = $request->input('sbid');
        $rollcall->presence = $request->input('presence');
        $rollcall->leave = $request->input('leave');
        $rollcall->late = $request->input('late');

        if ($rollcall->save())
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
        $rollcall = Rollcall::find($request->input('id'));

        if ($rollcall == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($rollcall->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
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
        $sbrecords = Sbrecord::Dormitory($request->input('dormitory'),$request->input('floor'))->get();
        $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
        $tags = [];
        $date = date("m/d");
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
        if(@$_POST[ '新增表單查詢' ] == '新增表單查詢'){
            return view("rollcalls.create",['display'=>2,'sbrecords'=>$sbrecords,'dormitories'=>$tags,"showPagination"=>True,"date"=>$date,"select"=>$request->input('dormitory'),'selectfloor'=>$request->input('floor')]);
        } 
        else
            return view("rollcalls.index",['display'=>2,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>false,'select'=>$request->input('dormitory')]);
    }

    public function create(){
        $sbrecords = Sbrecord::get();
        $dormitories = Bed::allDormitories()->get();
        $date = date("m/d");
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
        return view("rollcalls.create",['display'=>1,'sbrecords'=>$sbrecords,'dormitories'=>$tags,"showPagination"=>True,"date"=>$date,"select"=>1,"selectfloor"=>1]);
    }

    public function store(CreateRollcallRequest $request){
        // dd(count($request->input('edition')));
        $sbrecords = Sbrecord::get();
        $date = date("Y-m-d");
        $check = is_null($request->input("presence"));
        $leaves = Leave::leave()->get();
        if($request->input('edition')!=null){
            for($i=1;$i<=count($request->input('edition'));$i++){
                if ($check==true){
                    if(count($leaves)==0){
                        $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                        $rollcall = Rollcall::create([
                            'sbid' => $sbrecord->id,
                            'date' => $date,
                            'presence' => 0,
                            'leave' => 0,
                            // 'late' => $late,
                        ]); 
                    }
                    else{
                        foreach($leaves as $leave){
                            if($request->input('edition')[$i-1] == $leave->sbid){
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 1,
                                    // 'late' => $late,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    // 'late' => $late,
                                ]);
                            }
                        }
                    }
                }
                else{
                    if(count($leaves)==0){
                        foreach($request->input("presence") as $presence){
                            if($i == $presence){
                                $sbrecord = Sbrecord::findOrFail($presence);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 1,
                                    'leave' => 0,
                                    // 'late' => $late,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($i);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    // 'late' => $late,
                                ]);
                            }
                        }
                        
                    }
                    else{
                        foreach($leaves as $leave){
                            if($i == $leave->sbid){
                                $sbrecord = Sbrecord::findOrFail($i);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 1,
                                    'leave' => 1,
                                    // 'late' => $late,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($i);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    // 'late' => $late,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return redirect("rollcalls");
    }
    public function edit($id){
        $rollcall = Rollcall::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');  
        $selectDate = $rollcall->date;
        return view('rollcalls.edit',['display'=>3,'rollcall'=>$rollcall,'sbrecords'=>$sbrecords,'selectDate'=>$selectDate]);
    }
    public function update($id,CreateRollcallRequest $request){
        $rollcall = Rollcall::findOrFail($id);
        if($request->input('presence') == "on")
            $rollcall->presence = 1;
        else
            $rollcall->presence = 0;
        // $rollcall->leave = $request->input('leave');
        // $rollcall->late = $request->input('late');

        $rollcall->save();
        return redirect('rollcalls');
    }
}
