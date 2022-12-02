<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Models\Sbrecord;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Bed;

class SbrecordsController extends Controller
{
    //
    public function index(){
        $sbrecords = Sbrecord::all();
        return view("sbrecords.index",["sbrecords"=>$sbrecords]);
    }

    public function show($id){
        $sbrecord = Sbrecord::findOrFail($id);
        $rollcalls = $sbrecord->rollcalls;
        $leaves = $sbrecord->leaves;
        $lates = $sbrecord->lates;

        return view("sbrecords.show",["sbrecord"=>$sbrecord, "rollcalls"=>$rollcalls, "leaves"=>$leaves, "lates"=>$lates]);
    }

    public function destroy($id){
        $sbrecord = Sbrecord::findOrFail($id);
        $sbrecord->delete();
        return redirect("sbrecords");
    }
    public function create(){
        $student = Student::orderBy('students.id', 'asc')->pluck('students.name', 'students.id');
        $bed = Bed::orderBy('beds.id', 'asc')->pluck('beds.bedcode', 'beds.id');
        return view("sbrecords.create",["students"=>$student,"beds"=>$bed]);
    }
    
    public function store(){
        $input = Request::all();
        Sbrecord::create($input);
        return redirect("sbrecords");
    }
    public function edit($id){
        return view('sbrecords.edit');
    }
}
