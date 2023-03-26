<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
//use Request;
use App\Http\Requests\CreateStudentRequest;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    //
    public function index(){
        $students = Student::paginate(10);
        $classes = Student::allClasses()->get();
        $tags = [];
        foreach ($classes as $class)
        {
            $kv = mb_substr($class->class, 0, 2);
            $tags[$kv] = $kv;
            if($tags[$kv] == "電子"){
                $tags[$kv] = "電子工程系";
            }
            else if($tags[$kv] == "電機"){
                $tags[$kv] = "電機工程系";
            }
            else if($tags[$kv] == "化材"){
                $tags[$kv] = "化工與材料工程系";
            }
            else if($tags[$kv] == "機械"){
                $tags[$kv] = "機械工程系";
            }
            else if($tags[$kv] == "企管"){
                $tags[$kv] = "企業管理系";
            }
            else if($tags[$kv] == "資管"){
                $tags[$kv] = "資訊管理系";
            }
            else if($tags[$kv] == "國企"){
                $tags[$kv] = "國際企業系";
            }
            else if($tags[$kv] == "財金"){
                $tags[$kv] = "財務金融系";
            }
            else if($tags[$kv] == "工管"){
                $tags[$kv] = "工業管理系";
            }
            else if($tags[$kv] == "應外"){
                $tags[$kv] = "應用外語系";
            }
            else if($tags[$kv] == "遊戲"){
                $tags[$kv] = "多媒體與遊戲發展科學系";
            }
            else if($tags[$kv] == "觀光"){
                $tags[$kv] = "觀光休閒系";
            }
            else if($tags[$kv] == "文創"){
                $tags[$kv] = "文化創意與數位媒體設計系";
            }
            else{
                $tags[$kv] = "資訊網路工程系";
            }
        }
        return view("students.index",["students"=>$students,'classes'=>$tags,"showPagination"=>True,'select'=>1]);
    }
    
    public function api_students()
    {
        return Student::all();
    }

    public function api_update(Request $request)
    {
        $student = Student::find($request->input('id'));
        if ($student == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }
        
        $student->number = $request->input('number');
        $student->class = $request->input('class');
        $student->name = $request->input('name');
        $student->address = $request->input('address');
        $student->phone = $request->input('phone');
        $student->nationality = $request->input('nationality');
        $student->guardian = $request->input('guardian');
        $student->salutation = $request->input('salutation');
        $student->remark = $request->input('remark');

        if ($student->save())
        {
            return response()->json([
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'status' => 0,
            ]);
        }
    }

    public function api_delete(Request $request)
    {
        $student = Student::find($request->input('id'));

        if ($student == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($student->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
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
        $tags = [];
        foreach ($classes as $class)
        {
            $kv = mb_substr($class->class, 0, 2);
            $tags[$kv] = $kv;
            if($tags[$kv] == "電子"){
                $tags[$kv] = "電子工程系";
            }
            else if($tags[$kv] == "電機"){
                $tags[$kv] = "電機工程系";
            }
            else if($tags[$kv] == "化材"){
                $tags[$kv] = "化工與材料工程系";
            }
            else if($tags[$kv] == "機械"){
                $tags[$kv] = "機械工程系";
            }
            else if($tags[$kv] == "企管"){
                $tags[$kv] = "企業管理系";
            }
            else if($tags[$kv] == "資管"){
                $tags[$kv] = "資訊管理系";
            }
            else if($tags[$kv] == "國企"){
                $tags[$kv] = "國際企業系";
            }
            else if($tags[$kv] == "財金"){
                $tags[$kv] = "財務金融系";
            }
            else if($tags[$kv] == "工管"){
                $tags[$kv] = "工業管理系";
            }
            else if($tags[$kv] == "應外"){
                $tags[$kv] = "應用外語系";
            }
            else if($tags[$kv] == "遊戲"){
                $tags[$kv] = "多媒體與遊戲發展科學系";
            }
            else if($tags[$kv] == "觀光"){
                $tags[$kv] = "觀光休閒系";
            }
            else if($tags[$kv] == "文創"){
                $tags[$kv] = "文化創意與數位媒體設計系";
            }
            else{
                $tags[$kv] = "資訊網路工程系";
            }
        }
        return view("students.index",["students"=>$students,'classes'=>$tags,"showPagination"=>false,'select'=>$request->input('class')]);
    }

    public function create(){
        return view("students.create");
    }

    public function createdata(){
        return view("students.createdata");
    }

    public function store(CreateStudentRequest $request){
        $file = $request->file('profile');
        $number = $request->input('number');
        $class = $request->input('class');
        $name = $request->input('name');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $nationality = $request->input('nationality');
        $guardian = $request->input('guardian');
        $salutation = $request->input('salutation');
        $remark = $request->input('remark');
        $destinationPath = 'storage/uploads/profiles/'.$name;
        $file->move($destinationPath,"$name.".$file->getClientOriginalExtension());
        // dd($destinationPath);

        $student = Student::create([
            'profile_file_path'=>$destinationPath."/$name.".$file->getClientOriginalExtension(),
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
        // 新增學生資料時順便建立帳號
        $password = Hash::make($number);
        $user = User::create([
            'name' => $name,
            'email' => "$number@gm.lhu.edu.tw",
            'password' => $password
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
