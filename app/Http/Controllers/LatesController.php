<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Sbrecord;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateLateRequest;
use App\Models\Bed;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LatesController extends Controller
{
    //
    public function index(){
        $lates = Late::paginate(10);
        $all_lates = Late::get();
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

        return view("lates.index",['display'=>1,"lates"=>$lates,"all_lates"=>$all_lates,'dormitories'=>$tags,"showPagination"=>True,'select'=>1]);
    }

    public function show($id){
        $late = Late::findOrFail($id);
        return view('lates.show', ['late' => $late]);
    }
    public function dormitory(Request $request)
    {
        $lates = Late::Dormitory($request->input('dormitory'))->get();
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
        return view("lates.index",['display'=>2,"lates"=>$lates,'dormitories'=>$tags,"showPagination"=>false,'select'=>$request->input('dormitory')]);
    }
    public function examine($id){
        $late = Late::findOrFail($id);

        return view('lates.examine', ['late' => $late]);
    }
    public function destroy($id){
        $late = Late::findOrFail($id);
        $late->delete();
        return redirect('lates');
    }
    public function create(){
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   
        return view("lates.create",['sbrecords'=>$sbrecords]);
    }

    public function download($id){
        $late = Late::findOrFail($id);
        return response()->download($late->filename_path);
    }

    public function store(CreateLateRequest $request){
        $user_sbids = Sbrecord::User(Auth::user()->name)->get();
        foreach($user_sbids as $user_sbid){
            $sbid = $user_sbid->id;
        }
        $sbrecord = Sbrecord::FindOrFail($sbid);
        $bed = Bed::FindOrFail($sbrecord->bid);
        $start = $request->input('start');
        $end = $request->input('end');
        $reason = $request->input('reason');
        $company = $request->input('company');
        $contact = $request->input('contact');
        $address = $request->input('address');
        $back_time = $request->input('back_time');
        $filename_path = $request->file('filename_path');
        $destinationPath = 'storage/lates/'.date("md")."/".$bed->bedcode;
        $filename_path->move($destinationPath,"$bed->bedcode.".$filename_path->getClientOriginalExtension());
        $late = Late::create([
            'sbid' => $sbid,
            'start' => $start,
            'end' => $end,
            'reason' => $reason,
            'company' => $company,
            'contact' => $contact,
            'address' => $address,
            'back_time' => $back_time,
            'filename_path' => $destinationPath."/$bed->bedcode.".$filename_path->getClientOriginalExtension(),
        ]);
        return redirect("lates");
    }
    public function edit($id){
        $late = Late::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');
        $selectFloorhead_check = $late->floorhead_check;
        $selectChief_check = $late->chief_check;
        $selectHousemaster_check= $late->housemaster_check;
        $selectAdmin_check = $late->admin_check;
        return view('lates.edit',['late'=>$late,'sbrecords'=>$sbrecords,'selectFloorhead_check'=>$selectFloorhead_check,'selectChief_check'=>$selectChief_check,"selectHousemaster_check"=>$selectHousemaster_check,"selectAdmin_check"=>$selectAdmin_check]);
    }
    public function update($id,Request $request){
        $late = Late::findOrFail($id);

        $late->floorhead_check = $request->input('floorhead_check');
        $late->chief_check = $request->input('chief_check');
        $late->housemaster_check = $request->input('housemaster_check');
        $late->admin_check = $request->input('admin_check');

        $late->save();
        return redirect('lates');
    }
    
}
