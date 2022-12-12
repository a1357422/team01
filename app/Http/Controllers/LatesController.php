<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Sbrecord;
// use Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateLateRequest;
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
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        return view("lates.create",['sbrecords'=>$sbrecords]);
    }
    public function store(CreateLateRequest $request){
        $sbid = $request->input('sbid');
        $start = $request->input('start');
        $end = $request->input('end');
        $reason = $request->input('reason');
        $company = $request->input('company');
        $contact = $request->input('contact');
        $address = $request->input('address');
        $back_time = $request->input('back_time');
        $filename_path = $request->input('filename_path');

        $late = Late::create([
            'sbid' => $sbid,
            'start' => $start,
            'end' => $end,
            'reason' => $reason,
            'company' => $company,
            'contact' => $contact,
            'address' => $address,
            'back_time' => $back_time,
            'filename_path' => $filename_path,
        ]);
        return redirect("lates");
    }
    public function edit($id){
        $late = Late::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        $selectSbid = $late->sbid;
        $selectFloorhead_check = $late->floorhead_check;
        $selectChief_check = $late->chief_check;
        $selectHousemaster_check= $late->housemaster_check;
        $selectAdmin_check = $late->admin_check;
        return view('lates.edit',['late'=>$late,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid,'selectFloorhead_check'=>$selectFloorhead_check,'selectChief_check'=>$selectChief_check,"selectHousemaster_check"=>$selectHousemaster_check,"selectAdmin_check"=>$selectAdmin_check]);
    }
    public function update($id,CreateLateRequest $request){
        $late = Late::findOrFail($id);

        $late->sbid = $request->input('sbid');
        $late->start = $request->input('start');
        $late->end = $request->input('end');
        $late->reason = $request->input('reason');
        $late->company = $request->input('company');
        $late->contact = $request->input('contact');
        $late->address = $request->input('address');
        $late->back_time = $request->input('back_time');
        $late->filename_path = $request->input('filename_path');

        $late->save();
        return redirect('lates');
    }
}
