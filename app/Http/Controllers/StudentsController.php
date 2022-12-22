<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
// use Request;
use App\Http\Requests\CreateStudentRequest;

class StudentsController extends Controller
{
    //
    public function index(){
        $students = Student::paginate(10);
        $classes = Student::allClasses()->get();
        $data = [];
        foreach ($classes as $class)
        {
            $data["$class->class"] = $class->class;
            if($data["$class->class"] == "電子"){
                $data["$class->class"] = "電子工程系";
            }
            else if($data["$class->class"] == "電機"){
                $data["$class->class"] = "電機工程系";
            }
            else if($data["$class->class"] == "化材"){
                $data["$class->class"] = "化工與材料工程系";
            }
            else if($data["$class->class"] == "機械"){
                $data["$class->class"] = "機械工程系";
            }
            else if($data["$class->class"] == "企管"){
                $data["$class->class"] = "企業管理系";
            }
            else if($data["$class->class"] == "資管"){
                $data["$class->class"] = "資訊管理系";
            }
            else if($data["$class->class"] == "國企"){
                $data["$class->class"] = "國際企業系";
            }
            else if($data["$class->class"] == "財金"){
                $data["$class->class"] = "財務金融系";
            }
            else if($data["$class->class"] == "工管"){
                $data["$class->class"] = "工業管理系";
            }
            else if($data["$class->class"] == "應外"){
                $data["$class->class"] = "應用外語系";
            }
            else if($data["$class->class"] == "遊戲"){
                $data["$class->class"] = "多媒體與遊戲發展科學系";
            }
            else if($data["$class->class"] == "觀光"){
                $data["$class->class"] = "觀光休閒系";
            }
            else if($data["$class->class"] == "文創"){
                $data["$class->class"] = "文化創意與數位媒體設計系";
            }
            else{
                $data["$class->class"] = "資訊網路工程系";
            }
        }
        return view("students.index",["students"=>$students,'classes'=>$data,"showPagination"=>True]);
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

    public function class(Request $request)
    {
        $students = Student::class($request->input('class'))->get();
        $classes = Student::allClasses()->get();
        $data = [];
        foreach ($classes as $class)
        {
            if($data["$class->class"] == "電子"){
                $data["$class->class"] = "電子工程系";
            }
            else if($data["$class->class"] == "電機"){
                $data["$class->class"] = "電機工程系";
            }
            else if($data["$class->class"] == "化材"){
                $data["$class->class"] = "化工與材料工程系";
            }
            else if($data["$class->class"] == "機械"){
                $data["$class->class"] = "機械工程系";
            }
            else if($data["$class->class"] == "企管"){
                $data["$class->class"] = "企業管理系";
            }
            else if($data["$class->class"] == "資管"){
                $data["$class->class"] = "資訊管理系";
            }
            else if($data["$class->class"] == "國企"){
                $data["$class->class"] = "國際企業系";
            }
            else if($data["$class->class"] == "財金"){
                $data["$class->class"] = "財務金融系";
            }
            else if($data["$class->class"] == "工管"){
                $data["$class->class"] = "工業管理系";
            }
            else if($data["$class->class"] == "應外"){
                $data["$class->class"] = "應用外語系";
            }
            else if($data["$class->class"] == "遊戲"){
                $data["$class->class"] = "多媒體與遊戲發展科學系";
            }
            else if($data["$class->class"] == "觀光"){
                $data["$class->class"] = "觀光休閒系";
            }
            else if($data["$class->class"] == "文創"){
                $data["$class->class"] = "文化創意與數位媒體設計系";
            }
            else{
                $data["$class->class"] = "資訊網路工程系";
            }
        }

        return view("students.index",["students"=>$students,'classes'=>$data,"showPagination"=>false]);
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
            'number' => $number,
            'class' => $class,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'nationality' => $nationality,
            'guardian' => $guardian,
            'salutation' => $salutation,
            'remark' => $remark,
        ]);
        return redirect("students");
    }
    public function edit($id){
        $student = Student::findOrFail($id);
        return view('students.edit',['student'=>$student]);
    }
    public function update($id,CreateStudentRequest $request){
        $student = Student::findOrFail($id);

        $student->number = $request->input('number');
        $student->class = $request->input('class');
        $student->name = $request->input('name');
        $student->address = $request->input('address');
        $student->phone = $request->input('phone');
        $student->nationality = $request->input('nationality');
        $student->guardian = $request->input('guardian');
        $student->salutation = $request->input('salutation');
        $student->remark = $request->input('remark');

        $student->save();
        return redirect('students');
    }
}
