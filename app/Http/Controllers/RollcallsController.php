<?php

namespace App\Http\Controllers;

use App\Models\Rollcall;
// use Request
use App\Models\Sbrecord;
use App\Http\Requests\CreateRollcallRequest;
use App\Models\Bed;
use App\Models\Late;
use App\Models\Leave;
use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image; 

class RollcallsController extends Controller
{
    //
    public function index(){
        $rollcalls = Rollcall::orderBy('id','ASC')->paginate(10);
        $dormitories = Bed::allDormitories()->get();
        $tags = [];

        // $photo = Photo::get();
        // dd($photo);
        // $imagepath = $photo[1]->upload_file_path." ". $photo[0]->webcam_file_path;
        // $result = exec("python 照片辨識.py 2>error.txt $imagepath");
        // var_dump($result);
        
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

    public function upload($id)
    {
        $sbrecord=Sbrecord::findOrFail($id);
        return view('rollcalls.upload',["sbrecord"=>$sbrecord]);
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
            return view("rollcalls.create",['display'=>2,'sbrecords'=>$sbrecords,'dormitories'=>$tags,"showPagination"=>True,"date"=>$date,"select"=>$request->input('dormitory'),'selectfloor'=>$request->input('floor'),"MonthDay"=>date("md")]);
        } 
        else
            return view("rollcalls.index",['display'=>2,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>false,'select'=>$request->input('dormitory'),"MonthDay"=>date("md")]);
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
        return view("rollcalls.create",['display'=>1,'sbrecords'=>$sbrecords,'dormitories'=>$tags,"showPagination"=>True,"date"=>$date,"select"=>1,"selectfloor"=>1,"MonthDay"=>date("md")]);
    }

    public function store(CreateRollcallRequest $request){
        $files=$request->file('image');
        $sbrecords = Sbrecord::get();
        $date = date("Y-m-d");
        $check = is_null($request->input("presence"));
        $leaves = Leave::leave()->get();
        $lates = Late::late()->get();

        if($request->input('edition')!=null){
            for($i=1;$i<=count($request->input('edition'));$i++){
                if(in_array($i-1,array_keys($files))){
                    $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                    $bed = Bed::findOrFail($sbrecord->bid);
                    $destinationPath = 'storage/uploads/'.date("md")."/".$bed->bedcode;
                    $files[$i-1]->move($destinationPath,"$bed->bedcode.".$files[$i-1]->getClientOriginalExtension());
                    $photo = Photo::create([
                        'sbid' => $sbrecord->id,
                        'upload_file_path'=>$destinationPath."/$bed->bedcode.".$files[$i-1]->getClientOriginalExtension(),
                        'webcam_file_path'=>"",
                    ]);
                }
                if ($check==true){
                    if(count($leaves)==0 && count($lates)==0){
                        $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                        $rollcall = Rollcall::create([
                            'sbid' => $sbrecord->id,
                            'date' => $date,
                            'presence' => 0,
                            'leave' => 0,
                            'late' => 0,
                        ]); 
                    }
                    else{
                        $check_leave = Leave::FindLeavesbid($request->input('edition')[$i-1])->get();
                        $check_late = Late::FindLatesbid($request->input('edition')[$i-1])->get();
                        if(count($check_leave)==1 && count($check_late)==0){
                            if($request->input('edition')[$i-1] == $check_leave[0]->sbid){
                                if($check_leave[0]->floorhead_check != 0 && $check_leave[0]->housemaster_check != 0)
                                    $leave = 1;
                                else
                                    $leave = 0;
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => $leave,
                                    'late' => 0,
                                ]);
                            }
                        }
                        elseif(count($check_leave)==0 && count($check_late)==1){
                            if($request->input('edition')[$i-1] == $check_late[0]->sbid){
                                if($check_late[0]->floorhead_check != 0 && $check_late[0]->chief_check != 0 && $check_late[0]->housemaster_check != 0 && $check_late[0]->admin_check != 0)
                                    $late = 1;
                                else
                                    $late = 0;
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    'late' => $late,
                                ]);
                            }
                        }
                        elseif(count($check_leave)==1 && count($check_late)==1){
                            if($request->input('edition')[$i-1] == $check_leave[0]->sbid){
                                if($check_leave[0]->floorhead_check != 0 && $check_leave[0]->housemaster_check != 0)
                                    $leave = 1;
                                else
                                    $leave = 0;
                            }
                            if($request->input('edition')[$i-1] == $check_late[0]->sbid){
                                if($check_late[0]->floorhead_check != 0 && $check_late[0]->chief_check != 0 && $check_late[0]->housemaster_check != 0 && $check_late[0]->admin_check != 0)
                                    $late = 1;
                                else
                                    $late = 0;
                            }
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::create([
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 0,
                                'leave' => $leave,
                                'late' => $late,
                            ]);
                        }
                        else{
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::create([
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 0,
                                'leave' => 0,
                                'late' => 0,
                            ]);
                        }
                    }
                }
                else{
                    if(count($leaves)==0 && count($lates)==0){
                        if(in_array($request->input('edition')[$i-1],$request->input("presence")) == true){
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::create([
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 1,
                                'leave' => 0,
                                'late' => 0,
                            ]);
                        }
                        else{
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::create([
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 0,
                                'leave' => 0,
                                'late' => 0,
                            ]);
                        }
                    }
                    else{
                        $check_leave = Leave::FindLeavesbid($request->input('edition')[$i-1])->get();
                        $check_late = Late::FindLatesbid($request->input('edition')[$i-1])->get();
                        if(in_array($request->input('edition')[$i-1],$request->input("presence")) == true){
                            if(count($check_leave)==1 && count($check_late)==0){
                                if($request->input('edition')[$i-1] == $check_leave[0]->sbid){
                                    if($check_leave[0]->floorhead_check != 0 && $check_leave[0]->housemaster_check != 0)
                                        $leave = 1;
                                    else
                                        $leave = 0;
                                    $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                    $rollcall = Rollcall::create([
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 1,
                                        'leave' => $leave,
                                        'late' => 0,
                                    ]);
                                }
                            }
                            elseif(count($check_leave)==0 && count($check_late)==1){
                                if($request->input('edition')[$i-1] == $check_late[0]->sbid){
                                    if($check_late[0]->floorhead_check != 0 && $check_late[0]->chief_check != 0 && $check_late[0]->housemaster_check != 0 && $check_late[0]->admin_check != 0)
                                        $late = 1;
                                    else
                                        $late = 0;
                                    $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                    $rollcall = Rollcall::create([
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 1,
                                        'leave' => 0,
                                        'late' => $late,
                                    ]);
                                }
                            }
                            elseif(count($check_leave)==1 && count($check_late)==1){
                                if($request->input('edition')[$i-1] == $check_leave[0]->sbid){
                                    if($check_leave[0]->floorhead_check != 0 && $check_leave[0]->housemaster_check != 0)
                                        $leave = 1;
                                    else
                                        $leave = 0;
                                }
                                if($request->input('edition')[$i-1] == $check_late[0]->sbid){
                                    if($check_late[0]->floorhead_check != 0 && $check_late[0]->chief_check != 0 && $check_late[0]->housemaster_check != 0 && $check_late[0]->admin_check != 0)
                                        $late = 1;
                                    else
                                        $late = 0;
                                }
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 1,
                                    'leave' => $leave,
                                    'late' => $late,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 1,
                                    'leave' => 0,
                                    'late' => 0,
                                ]);
                            }
                        }
                        else{
                            if(count($check_leave)==1 && count($check_late)==0){
                                if($request->input('edition')[$i-1] == $check_leave[0]->sbid){
                                    if($check_leave[0]->floorhead_check != 0 && $check_leave[0]->housemaster_check != 0)
                                        $leave = 1;
                                    else
                                        $leave = 0;
                                    $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                    $rollcall = Rollcall::create([
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 0,
                                        'leave' => $leave,
                                        'late' => 0,
                                    ]);
                                }
                            }
                            elseif(count($check_leave)==0 && count($check_late)==1){
                                if($request->input('edition')[$i-1] == $check_late[0]->sbid){
                                    if($check_late[0]->floorhead_check != 0 && $check_late[0]->chief_check != 0 && $check_late[0]->housemaster_check != 0 && $check_late[0]->admin_check != 0)
                                        $late = 1;
                                    else
                                        $late = 0;
                                    $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                    $rollcall = Rollcall::create([
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 0,
                                        'leave' => 0,
                                        'late' => $late,
                                    ]);
                                }
                            }
                            elseif(count($check_leave)==1 && count($check_late)==1){
                                if($request->input('edition')[$i-1] == $check_leave[0]->sbid){
                                    if($check_leave[0]->floorhead_check != 0 && $check_leave[0]->housemaster_check != 0)
                                        $leave = 1;
                                    else
                                        $leave = 0;
                                }
                                if($request->input('edition')[$i-1] == $check_late[0]->sbid){
                                    if($check_late[0]->floorhead_check != 0 && $check_late[0]->chief_check != 0 && $check_late[0]->housemaster_check != 0 && $check_late[0]->admin_check != 0)
                                        $late = 1;
                                    else
                                        $late = 0;
                                }
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => $leave,
                                    'late' => $late,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::create([
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    'late' => 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return redirect("rollcalls");
    }

    public function storeimage(Request $request)
    {
        $sbrecords = Sbrecord::get();
        $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
        $tags = [];
        $date = date("md");
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

        $img = $request->image;
        if($img!=null){
            $folderPath = "webcams/".$date."/".$request->input('bedcode')."/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            // $fileName = uniqid() . '.png';
            $fileName = $request->input('bedcode');
            $file = $folderPath . $fileName.'.png';
            Storage::disk('public')->put($file, $image_base64);
            $upload = Photo::create([
                'sbid' => $request->input('sbid'),
                'upload_file_path'=>"",
                'webcam_file_path'=>"storage/".$file,
            ]);
        }
        return redirect("rollcalls/create");
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
