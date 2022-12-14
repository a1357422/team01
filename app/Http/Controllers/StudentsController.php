<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
// use Request;
use App\Http\Requests\CreateStudentRequest;

class StudentsController extends Controller
{
    //
    public function index(){
        $students = Student::paginate(25);
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

    public function store(CreateStudentRequest $request){
        $number = $request->input('number');
        $class = $request->input('class');
        $name = $request->input('name');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $nationality = $request->input('nationality');
        $guardian = $request->input('guardian');
        $salutation = $request->input('salutation');
        $remark = $request->input('remark');

        $student = Student::create([
            'number'=>$number,
            'class'=>$class,
            'name'=>$name,
            'address'=>$address,
            'phone'=>$phone,
            'nationality'=>$nationality,
            'guardian'=>$guardian,
            'salutation'=>$salutation,
            'remark'=>$remark,
        ]);
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
