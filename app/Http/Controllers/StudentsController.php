<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Request;

class StudentsController extends Controller
{
    //
    public function index(){
        $students = Student::all();
        return view("students.index",["students"=>$students]);
    }
    
    public function show($id){
        $student = Student::findOrFail($id);

        return view('students.show', ['student' => $student]);
    }

    public function destroy($id){
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('students');
    }

    public function create(){
        return view("students.create");
    }

    public function store(){
        $input = Request::all();
        Student::create($input);
        return redirect("students");
    }
    public function edit($id){
        $student = Student::findOrFail($id);
        return view('students.edit',['student'=>$student]);
    }
    public function update($id){
        $input = Request::all();
        $student = Student::findOrFail($id);

        $student->number = $input['number'];
        $student->class = $input['class'];
        $student->name = $input['name'];
        $student->address = $input['address'];
        $student->phone = $input['phone'];
        $student->nationality = $input['nationality'];
        $student->guardian = $input['guardian'];
        $student->salutation = $input['salutation'];
        $student->remark = $input['remark'];

        $student->save();
        return redirect('students');
    }
}
