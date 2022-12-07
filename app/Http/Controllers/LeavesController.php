<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;

class LeavesController extends Controller
{
    //
    public function index(){
        $leaves = Leave::paginate(10);
        return view("leaves.index",["leaves"=>$leaves]);
    }

    public function show($id){
        $leave = Leave::findOrFail($id);

        return view('leaves.show', ['leave' => $leave]);
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
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.bid', 'sbrecords.id');
        return view("leaves.create",["sbrecords"=>$sbrecords]);
    }
    public function store(){
        $input = Request::all();
        Leave::create($input);
        return redirect("leaves");
    }
    public function edit($id){
        $leave = Leave::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.bid', 'sbrecords.id');
        $selectSbid = $leave->sbid;
        return view('leaves.edit',['leave'=>$leave,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid]);
    }
    public function update($id){
        $input = Request::all();
        $leave = Leave::findOrFail($id);

        $leave->sbid = $input['sbid'];
        $leave->start = $input['start'];
        $leave->end = $input['end'];
        $leave->reason = $input['reason'];
        $leave->floorhead_check = $input['floorhead_check'];
        $leave->housemaster_check = $input['housemaster_check'];

        $leave->save();
        return redirect('leaves');
    }
}