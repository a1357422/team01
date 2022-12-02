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
        return view('rollcalls.edit');
    }
}
