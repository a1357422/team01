<?php

namespace App\Http\Controllers;

use App\Models\Rollcall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;

class RollcallsController extends Controller
{
    //
    public function index(){
        $rollcalls = Rollcall::all();
        return view("rollcalls.index",["rollcalls"=>$rollcalls]);
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
    public function create(){
        $sbrecord = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.sid', 'sbrecords.id');
        return view("rollcalls.create",['sbrecords'=>$sbrecord]);
    }
    public function store(){
        $input = Request::all();
        Rollcall::create($input);
        return redirect("rollcalls");
    }
    public function edit($id){
        $rollcall = Rollcall::findOrFail($id);
        $sbrecord = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.sid', 'sbrecords.id');
        $selectSbid = $rollcall->sbid;
        return view('rollcalls.edit',['rollcall'=>$rollcall,'sbrecord'=>$sbrecord,'selectSbid'=>$selectSbid]);
    }
    public function update($id){
        $input = Request::all();
        $rollcall = Late::findOrFail($id);

        $rollcall->date = $input['date'];
        $rollcall->sbid = $input['sbid'];
        $rollcall->presence = $input['presence'];
        $rollcall->leave = $input['leave'];
        $rollcall->late = $input['late'];

        $rollcall->save();
        return redirect('rollcalls');
    }
}
