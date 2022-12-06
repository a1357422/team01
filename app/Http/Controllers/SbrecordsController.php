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
        $students = Student::orderBy('students.id', 'asc')->pluck('students.name', 'students.id');
        $beds = Bed::orderBy('beds.id', 'asc')->pluck('beds.bedcode', 'beds.id');
        return view("sbrecords.create",["students"=>$students,"beds"=>$beds]);
    }
    
    public function store(){
        $input = Request::all();
        Sbrecord::create($input);
        return redirect("sbrecords");
    }
    public function edit($id){
        $sbrecord = Sbrecord::findOrFail($id);
        $students = Student::orderBy('students.id', 'asc')->pluck('students.name', 'students.id');
        $beds = Bed::orderBy('beds.id', 'asc')->pluck('beds.bedcode', 'beds.id');
        $selectSemester = $sbrecord->semester;
        $selectName = $sbrecord->sid;
        $selectBedcode = $sbrecord->bid;
        $selectFloor_head = $sbrecord->floor_head;
        $selectResponsible_floor = $sbrecord->responsible_floor;

        return view('sbrecords.edit',['sbrecord'=>$sbrecord,"students"=>$students,"beds"=>$beds, "selectsemester"=>$selectSemester, 'selectName'=>$selectName,'selectBedcode'=>$selectBedcode, "selectFloor_head"=>$selectFloor_head, "selectResponsible_floor"=>$selectResponsible_floor]);
    }
    public function update($id){
        $input = Request::all();
        $sbrecord = Sbrecord::findOrFail($id);

        $sbrecord->school_year = $input['school_year'];
        $sbrecord->semester = $input['semester'];
        $sbrecord->sid = $input['sid'];
        $sbrecord->bid = $input['bid'];
        $sbrecord->floor_head = $input['floor_head'];
        $sbrecord->responsible_floor = $input['responsible_floor'];

        $sbrecord->save();
        return redirect('sbrecords');
    }
}
