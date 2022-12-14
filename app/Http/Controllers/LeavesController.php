<?php

namespace App\Http\Controllers;

use App\Models\Leave;
// use Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;
use App\Http\Requests\CreateLeaveRequest;

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