<?php

namespace App\Http\Controllers;

use App\Models\Rollcall;
use Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;

class RollcallsController extends Controller
{
    //
    public function index(){
        $rollcalls = Rollcall::paginate(10);
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
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.bid', 'sbrecords.id');
        return view("rollcalls.create",['sbrecords'=>$sbrecords]);
    }
    public function store(){
        $input = Request::all();
        Rollcall::create($input);
        return redirect("rollcalls");
    }
    public function edit($id){
        $rollcall = Rollcall::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.bid', 'sbrecords.id');
        $selectSbid = $rollcall->sbid;
        $selectPresence = $rollcall->presence;
        $selectLeave = $rollcall->leave;
        $selectLate = $rollcall->late;
        return view('rollcalls.edit',['rollcall'=>$rollcall,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid,'selectPresence'=>$selectPresence,'selectLeave'=>$selectLeave,'selectLate'=>$selectLate]);
    }
    public function update($id){
        $input = Request::all();
        $rollcall = Rollcall::findOrFail($id);

        $rollcall->date = $input['date'];
        $rollcall->sbid = $input['sbid'];
        $rollcall->presence = $input['presence'];
        $rollcall->leave = $input['leave'];
        $rollcall->late = $input['late'];

        $rollcall->save();
        return redirect('rollcalls');
    }
}
