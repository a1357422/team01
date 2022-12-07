<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Sbrecord;
use Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class LatesController extends Controller
{
    //
    public function index(){
        $lates = Late::paginate(10);
        return view("lates.index",["lates"=>$lates]);
    }
    public function show($id){
        $late = Late::findOrFail($id);

        return view('lates.show', ['late' => $late]);
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
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.bid', 'sbrecords.id');
        return view("lates.create",['sbrecords'=>$sbrecords]);
    }
    public function store(){
        $input = Request::all();
        Late::create($input);
        return redirect("lates");
    }
    public function edit($id){
        $late = Late::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.bid', 'sbrecords.id');
        $selectSbid = $late->sbid;
        $selectFloorhead_check = $late->floorhead_check;
        $selectChief_check = $late->chief_check;
        $selectHousemaster_check= $late->housemaster_check;
        $selectAdmin_check = $late->admin_check;
        return view('lates.edit',['late'=>$late,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid,'selectFloorhead_check'=>$selectFloorhead_check,'selectChief_check'=>$selectChief_check,"selectHousemaster_check"=>$selectHousemaster_check,"selectAdmin_check"=>$selectAdmin_check]);
    }
    public function update($id){
        $input = Request::all();
        $late = Late::findOrFail($id);

        $late->sbid = $input['sbid'];
        $late->start = $input['start'];
        $late->end = $input['end'];
        $late->reason = $input['reason'];
        $late->company = $input['company'];
        $late->contact = $input['contact'];
        $late->address = $input['address'];
        $late->back_time = $input['back_time'];
        $late->filename_path = $input['filename_path'];
        $late->floorhead_check = $input['floorhead_check'];
        $late->chief_check = $input['chief_check'];
        $late->housemaster_check = $input['housemaster_check'];
        $late->admin_check = $input['admin_check'];

        $late->save();
        return redirect('lates');
    }
}
