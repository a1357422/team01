<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sbrecord;

class LeavesController extends Controller
{
    //
    public function index(){
        $leaves = Leave::all();
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
        $sbrecord = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.sid', 'sbrecords.id');
        return view("leaves.create",["sbrecords"=>$sbrecord]);
    }
    public function store(){
        $input = Request::all();
        Leave::create($input);
        return redirect("leaves");
    }
    public function edit($id){
        return view('leaves.edit');
    }
}
