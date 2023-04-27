<?php

namespace App\Http\Controllers;

use App\Models\Rollcall;
// use Request
use App\Models\Sbrecord;
use App\Http\Requests\CreateRollcallRequest;
use App\Models\Bed;
use App\Models\Dormitory;
use App\Models\Late;
use App\Models\Leave;
use App\Models\Photo;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image; 

class RollcallsController extends Controller
{
    //
    public function index(){
        $rollcalls = Rollcall::Where('date',date("Y-m-d"))->orderBy('id','ASC')->paginate(10);
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

        return view("rollcalls.index",['display'=>1,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>True,'select'=>1,'textbox'=>False]);
    }

    public function history(){
        $rollcalls = Rollcall::orderBy('id','ASC')->paginate(10);
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
        return view("rollcalls.index",['display'=>5,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>True,'select'=>1,'textbox'=>False,'date'=>date("Y-m-d")]);
    }

    public function presence()
    {
        $rollcalls = Rollcall::Presence()->get();
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
        return view("rollcalls.index",['display'=>3,"rollcalls"=>$rollcalls,'dormitories'=>$tags,"showPagination"=>False,'select'=>1,'textbox'=>True,'date'=>date('m/d')]);
    }


    public function upload($bedcode)
    {
        $sbrecords=Sbrecord::RoomCode($bedcode)->get();
        return view('rollcalls.upload',["sbrecords"=>$sbrecords]);
    }
    public function show($id){
        $rollcall = Rollcall::findOrFail($id);
        $photo = Photo::Where('sbid',$rollcall->sbid)->first();
        $sbrecord = Sbrecord::findOrFail($rollcall->sbid);
        $student = Student::findOrFail($sbrecord->sid);
        if($photo != null){
            if ($photo->webcam_file_path != "")
                $photo_path = $photo->webcam_file_path;
            else
                $photo_path = $photo->upload_file_path;
        }
        else
            $photo_path = "";
        if ($student->profile_file_path != "")
            $profile_path = $student->profile_file_path;
        else
            $profile_path = "";
        $date=date("md");
        $roomcodes = [];
        $bedcodes = Bed::get();
        foreach($bedcodes as $bedcode){
            array_push($roomcodes,substr($bedcode->bedcode,0,5));
            $roomcodes = array_unique($roomcodes);
        }
        return view("rollcalls.show",["rollcall"=>$rollcall,"roomcodes"=>$roomcodes,"MonthDay"=>$date,"photo_path"=>$photo_path,"profile_path"=>$profile_path]);
    }

    public function destroy($id){
        $rollcall = Rollcall::findOrFail($id);
        $rollcall->delete();
        return redirect("rollcalls");
    }

    public function dormitory(Request $request)
    {
        $sbrecords = Sbrecord::Dormitory($request->input('dormitory'),$request->input('floor'))->get();
        $sbrecordcount = count($sbrecords);
        $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
        $dormitory = Dormitory::findOrFail($request->input('dormitory'));
        if($dormitory->name == "女一宿")
            $dormitorycode = "81";
        elseif($dormitory->name == "女二宿"||$dormitory->name == "男一宿")
            $dormitorycode = "82";
        else
            $dormitorycode = "83";
        $bedcode_prefix = $dormitorycode . $request->input('floor'); 
        $roomcodes = [];
        $bedcodes = Bed::Bedcode($bedcode_prefix)->get();
        foreach($bedcodes as $bedcode){
            array_push($roomcodes,substr($bedcode->bedcode,0,5));
            $roomcodes = array_unique($roomcodes);
        }
        $tags = [];
        $date = date("m/d");
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
        $photos = Photo::get();
        $roomnumbers = [];
        foreach ($photos as $photo){
            if($photo->date == date("Y-m-d")){
                $sbrecord = Sbrecord::findOrFail($photo->sbid);
                $bed = Bed::findOrFail($sbrecord->bid);
                $bedcode = substr($bed->bedcode,0,5);
                array_push($roomnumbers,$bedcode);
                $roomnumbers = array_unique($roomnumbers);
            }
        }
        if(@$_POST[ '新增表單查詢' ] == '新增表單查詢')
            return view("rollcalls.create",['display'=>2,'sbrecords'=>$sbrecords,'sbrecordcount'=>$sbrecordcount,'dormitories'=>$tags,'roomcodes'=>$roomcodes,"showPagination"=>True,"date"=>$date,"select"=>$request->input('dormitory'),'selectfloor'=>$request->input('floor'),"MonthDay"=>date("md"),'roomnumbers'=>$roomnumbers,"photos"=>$photos]);
        else if (@$_POST[ '表單查詢' ] == '表單查詢')
            return view("rollcalls.index",['display'=>2,"rollcalls"=>$rollcalls,'sbrecordcount'=>$sbrecordcount,'dormitories'=>$tags,'roomcodes'=>$roomcodes,"showPagination"=>false,'select'=>$request->input('dormitory'),"MonthDay"=>date("md"),'textbox'=>False]);
        else if (@$_POST[ '未到人員查詢' ] == '未到人員查詢'){
            $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->where('rollcalls.presence',0)->where('rollcalls.date',date("Y-m-d"))->get();
            return view("rollcalls.index",['display'=>4,"rollcalls"=>$rollcalls,'sbrecordcount'=>$sbrecordcount,'dormitories'=>$tags,'roomcodes'=>$roomcodes,"showPagination"=>false,'select'=>$request->input('dormitory'),"MonthDay"=>date("md"),'textbox'=>True,"date"=>date("m/d")]);
        }
        else{
            $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->where('date',$request->input('date'))->get();
            return view("rollcalls.index",['display'=>6,"rollcalls"=>$rollcalls,'sbrecordcount'=>$sbrecordcount,'dormitories'=>$tags,'roomcodes'=>$roomcodes,"showPagination"=>false,'select'=>$request->input('dormitory'),"MonthDay"=>date("md"),'textbox'=>True,'date' => $request->input('date')]);
        }
    }

    public function create(){
        if(Sbrecord::User(Auth::user()->name)->first() != null){
            $floorhead = Sbrecord::User(Auth::user()->name)->first();
            $floor = substr($floorhead->responsible_floor,0,1);
            $bed = Bed::findOrFail($floorhead->bid);
            $bedcode_prefix = substr($bed->bedcode,0,2) . $floor; 
            $roomcodes = [];
            $bedcodes = Bed::Bedcode($bedcode_prefix)->get();
            $photos = Photo::get();
            $roomnumbers = [];
            foreach ($photos as $photo){
                if($photo->date == date("Y-m-d")){
                    $sbrecord = Sbrecord::findOrFail($photo->sbid);
                    $bed = Bed::findOrFail($sbrecord->bid);
                    $bedcode = substr($bed->bedcode,0,5);
                    array_push($roomnumbers,$bedcode);
                    $roomnumbers = array_unique($roomnumbers);
                }
            }
            foreach($bedcodes as $bedcode){
                array_push($roomcodes,substr($bedcode->bedcode,0,5));
                $roomcodes = array_unique($roomcodes);
            }
            if(substr($bed->bedcode,0,2) == "81")
                $dormitory = 1;
            elseif(substr($bed->bedcode,0,2) == "82"){
                if ($floor == "1"){
                    $int_value = (int)(substr($bed->bedcode,3,2));
                    if($int_value>11)$dormitory=2;
                    else $dormitory=3;
                }
                elseif ($floor == "2"){
                    $int_value = (int)(substr($bed->bedcode,3,2));
                    if($int_value>14)$dormitory=2;
                    else $dormitory=3;
                }
                else $dormitory=3;
            }
            elseif(substr($bed->bedcode,0,2) == "83")
                $dormitory = 4;
            $sbrecords = Sbrecord::Dormitory($dormitory,$floor)->get();
        }
        else{
            $roomcodes = [];
            $bedcodes = Bed::get();
            $photos = Photo::get();
            $roomnumbers = [];
            foreach ($photos as $photo){
                if($photo->date == date("Y-m-d")){
                    $sbrecord = Sbrecord::findOrFail($photo->sbid);
                    $bed = Bed::findOrFail($sbrecord->bid);
                    $bedcode = substr($bed->bedcode,0,5);
                    array_push($roomnumbers,$bedcode);
                    $roomnumbers = array_unique($roomnumbers);
                }
            }
            foreach($bedcodes as $bedcode){
                array_push($roomcodes,substr($bedcode->bedcode,0,5));
                $roomcodes = array_unique($roomcodes);
            }
            $sbrecords = Sbrecord::get();
        }
        $sbrecordcount = count($sbrecords);
        $dormitories = Bed::allDormitories()->get();
        $date = date("m/d");
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
        return view("rollcalls.create",['display'=>1,'sbrecords'=>$sbrecords,'sbrecordcount'=>$sbrecordcount,'dormitories'=>$tags,'roomnumbers'=>$roomnumbers,'roomcodes'=>$roomcodes,"showPagination"=>True,"date"=>$date,"select"=>1,"selectfloor"=>1,"MonthDay"=>date("md"),"photos"=>$photos]);
    }

    public function store(CreateRollcallRequest $request){
        $roomphotos = $request->file('roomimage');
        $sbrecords = Sbrecord::get();
        $date = date("Y-m-d");
        $check = is_null($request->input("presence"));
        $leaves = Leave::leave()->get();
        $lates = Late::late()->get();
        if($request->input('edition')!=null){
            if($roomphotos != null){
                for($j=1;$j<=count($request->input("roomcodes"));$j++){
                    if(in_array($j-1,array_keys($roomphotos))){
                        $sbrecords = Sbrecord::RoomCode($request->input("roomcodes")[$j-1])->get();
                        $destinationPath = 'storage/uploads/'.date("md")."/".$request->input("roomcodes")[$j-1];
                        $roomphotos[$j-1]->move($destinationPath,$request->input("roomcodes")[$j-1].".".$roomphotos[$j-1]->getClientOriginalExtension());
                        foreach($sbrecords as $sbrecord){
                            $photo_sbid = Photo::FindPhotoSbid($sbrecord->id)->get();
                            if(count($photo_sbid)==0){
                                $photo = Photo::create([
                                'date' => date("Y-m-d"),
                                'sbid' => $sbrecord->id,
                                'upload_file_path'=>$destinationPath."/".$request->input("roomcodes")[$j-1].".".$roomphotos[$j-1]->getClientOriginalExtension(),
                                'webcam_file_path'=>"",
                                ]);
                            }
                            else{
                                $photo = Photo::FindPhotoSbid($sbrecord->id)->first();
                                $photo->upload_file_path = $destinationPath."/".$request->input("roomcodes")[$j-1].".".$roomphotos[$j-1]->getClientOriginalExtension();
                                $photo->save();
                            }
                        }
                    }
                }
            }
            for($i=1;$i<=count($request->input('edition'));$i++){
                if ($check==true){
                    if(count($leaves)==0 && count($lates)==0){
                        $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                        $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                            'rollcaller' => Auth::user()->name,
                            'sbid' => $sbrecord->id,
                            'date' => $date,
                            'presence' => 0,
                            'leave' => 0,
                            'late' => 0,
                            'identify' => 0,
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
                                $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                    'rollcaller' => Auth::user()->name,
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => $leave,
                                    'late' => 0,
                                    'identify' => 0,
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
                                $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                    'rollcaller' => Auth::user()->name,
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    'late' => $late,
                                    'identify' => 0,
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
                            $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                'rollcaller' => Auth::user()->name,
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 0,
                                'leave' => $leave,
                                'late' => $late,
                                'identify' => 0,
                            ]);
                        }
                        else{
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                'rollcaller' => Auth::user()->name,
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 0,
                                'leave' => 0,
                                'late' => 0,
                                'identify' => 0,
                            ]);
                        }
                    }
                }
                else{
                    if(count($leaves)==0 && count($lates)==0){
                        if(in_array($request->input('edition')[$i-1],$request->input("presence")) == true){
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                'rollcaller' => Auth::user()->name,
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 1,
                                'leave' => 0,
                                'late' => 0,
                                'identify' => 0,
                            ]);
                        }
                        else{
                            $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                            $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                'rollcaller' => Auth::user()->name,
                                'sbid' => $sbrecord->id,
                                'date' => $date,
                                'presence' => 0,
                                'leave' => 0,
                                'late' => 0,
                                'identify' => 0,
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
                                    $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                        'rollcaller' => Auth::user()->name,
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 1,
                                        'leave' => $leave,
                                        'late' => 0,
                                        'identify' => 0,
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
                                    $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                        'rollcaller' => Auth::user()->name,
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 1,
                                        'leave' => 0,
                                        'late' => $late,
                                        'identify' => 0,
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
                                $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                    'rollcaller' => Auth::user()->name,
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 1,
                                    'leave' => $leave,
                                    'late' => $late,
                                    'identify' => 0,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                    'rollcaller' => Auth::user()->name,
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 1,
                                    'leave' => 0,
                                    'late' => 0,
                                    'identify' => 0,
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
                                    $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                        'rollcaller' => Auth::user()->name,
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 0,
                                        'leave' => $leave,
                                        'late' => 0,
                                        'identify' => 0,
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
                                    $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                        'rollcaller' => Auth::user()->name,
                                        'sbid' => $sbrecord->id,
                                        'date' => $date,
                                        'presence' => 0,
                                        'leave' => 0,
                                        'late' => $late,
                                        'identify' => 0,
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
                                $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                    'rollcaller' => Auth::user()->name,
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => $leave,
                                    'late' => $late,
                                    'identify' => 0,
                                ]);
                            }
                            else{
                                $sbrecord = Sbrecord::findOrFail($request->input('edition')[$i-1]);
                                $rollcall = Rollcall::updateOrCreate(['sbid'=>$sbrecord->id,'date'=>$date],[
                                    'rollcaller' => Auth::user()->name,
                                    'sbid' => $sbrecord->id,
                                    'date' => $date,
                                    'presence' => 0,
                                    'leave' => 0,
                                    'late' => 0,
                                    'identify' => 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $rollcalls = Rollcall::get();
        $photos = Photo::get();
        for($i=1;$i<=count($rollcalls);$i++){
            foreach ($photos as $photo){
                if($rollcalls[$i-1]->sbid==$photo->sbid && $photo->date == date("Y-m-d")){
                    $sbrecord = Sbrecord::findOrFail($rollcalls[$i-1]->sbid);
                    $student = Student::findOrFail($sbrecord->sid);
                    if ($photo->webcam_file_path != "")
                        $imagepath = $photo->webcam_file_path." ". $student->profile_file_path;
                    elseif($photo->upload_file_path != "")
                        $imagepath = $photo->upload_file_path." ". $student->profile_file_path;
                    else
                        break;
                    $result = exec("python 照片辨識.py 2>error.txt $imagepath");
                    if($result == "success")
                        $rollcalls[$i-1]->identify = 1;
                    else
                        $rollcalls[$i-1]->identify = 0;
                    $rollcalls[$i-1]->save();
                }
            }
        }
        return redirect("rollcalls");
    }

    public function storeimage(Request $request)
    {
        foreach($request->input('bedcodes') as $bedcode)
            $newbedcodes = substr($bedcode,0,5);
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
            $folderPath = "webcams/".$date."/".$newbedcodes."/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $newbedcodes;
            $file = $folderPath . $fileName.'.png';
            $sbid = $request->input('sbid');
            Storage::disk('public')->put($file, $image_base64);
            foreach($request->input('sbids') as $sbid){
                $photo_sbid = Photo::FindPhotoSbid($sbid)->get();
                if(count($photo_sbid)==0){
                    $upload = Photo::create([
                        'date' => date("Y-m-d"),
                        'sbid' => $sbid,
                        'upload_file_path'=>"",
                        'webcam_file_path'=>"storage/".$file,
                    ]);
                }
                else{
                    $photo = Photo::FindPhotoSbid($sbid)->first();
                    $photo->webcam_file_path = "storage/".$file;
                    $photo->save();
                }
            }
        }
        return redirect("rollcalls/create");
    }

    public function edit($id){
        $rollcall = Rollcall::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');  
        $selectDate = $rollcall->date;
        $selectPresence = $rollcall->presence;
        return view('rollcalls.edit',['display'=>3,'rollcall'=>$rollcall,'sbrecords'=>$sbrecords,'selectDate'=>$selectDate,'selectPresence'=>$selectPresence,"MonthDay"=>date("md")]);
    }
    public function update($id,CreateRollcallRequest $request){
        $rollcall = Rollcall::findOrFail($id);
        if($request->input('presence') != null){
            $rollcall->presence = 1;
        }
        else{
            $rollcall->presence = 0;
        }
        $rollcall->rollcaller = Auth::user()->name;
        $rollcall->save();
        return redirect('rollcalls');
    }
}
