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
            $tags[$class->class] = $class->class;
            if(preg_match("/子/",$tags[$class->class]))
                $tags[$class->class] = "電子工程系";
            else if((preg_match("/電/",$tags[$class->class]) && preg_match("/電機/",$tags[$class->class]))||preg_match("/四電/",$tags[$class->class]))
                $tags[$class->class] = "電機工程系";
            else if(preg_match("/化材/",$tags[$class->class]))
                $tags[$class->class] = "化工與材料工程系";
            else if((preg_match("/機/",$tags[$class->class]) && preg_match("/機械/",$tags[$class->class])||preg_match("/機/",$tags[$class->class])))
                $tags[$class->class] = "機械工程系";
            else if(preg_match("/企管/",$tags[$class->class]))
                $tags[$class->class] = "企業管理系";
            else if(preg_match("/資管/",$tags[$class->class]))
                $tags[$class->class] = "資訊管理系";
            else if(preg_match("/國企/",$tags[$class->class]))
                $tags[$class->class] = "國際企業系";
            else if(preg_match("/財/",$tags[$class->class]))
                $tags[$class->class] = "財務金融系";
            else if(preg_match("/工管/",$tags[$class->class])||preg_match("/管/",$tags[$class->class]))
                $tags[$class->class] = "工業管理系";
            else if(preg_match("/應/",$tags[$class->class]))
                $tags[$class->class] = "應用外語系";
            else if(preg_match("/遊/",$tags[$class->class]))
                $tags[$class->class] = "多媒體與遊戲發展科學系";
            else if(preg_match("/觀/",$tags[$class->class]))
                $tags[$class->class] = "觀光休閒系";
            else if(preg_match("/文/",$tags[$class->class]))
                $tags[$class->class] = "文化創意與數位媒體設計系";
            else if((preg_match("/網/",$tags[$class->class]) && preg_match("/資網/",$tags[$class->class])||preg_match("/網/",$tags[$class->class])))
                $tags[$class->class] = "資訊網路工程系";
            else if(preg_match("/專班/",$tags[$class->class]))
                $tags[$class->class] = "PBL專班";
            else if(preg_match("/萬能/",$tags[$class->class]))
                $tags[$class->class] = "萬能";
            else if(preg_match("/羅東/",$tags[$class->class]))
                $tags[$class->class] = "羅東";
            else if(preg_match("/高苑/",$tags[$class->class]))
                $tags[$class->class] = "高苑";
            else if(preg_match("/海青/",$tags[$class->class]))
                $tags[$class->class] = "海青班";
            else if(preg_match("/國際學/",$tags[$class->class]))
                $tags[$class->class] = "國際學生";
            else if((preg_match("/4/",$tags[$class->class])||preg_match("/新南向/",$tags[$class->class])))
                $tags[$class->class] = "新南向(4+1)";
            else
                $tags[$class->class] = "其他";
    }
        $tags = array_unique($tags);
        $tags = array_diff($tags,["其他"]);
        return view("students.index",["students"=>$students,'classes'=>$tags,"showPagination"=>True,'select'=>1]);
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

    public function name(Request $request){
        $students = Student::Where('name',$request->input('name'))->get();
        $classes = Student::allClasses()->get();
        $tags = [];
        foreach ($classes as $class)
        {
            $tags[$class->class] = $class->class;
            if(preg_match("/子/",$tags[$class->class]))
                $tags[$class->class] = "電子工程系";
            else if((preg_match("/電/",$tags[$class->class]) && preg_match("/電機/",$tags[$class->class]))||preg_match("/四電/",$tags[$class->class]))
                $tags[$class->class] = "電機工程系";
            else if(preg_match("/化材/",$tags[$class->class]))
                $tags[$class->class] = "化工與材料工程系";
            else if((preg_match("/機/",$tags[$class->class]) && preg_match("/機械/",$tags[$class->class])||preg_match("/機/",$tags[$class->class])))
                $tags[$class->class] = "機械工程系";
            else if(preg_match("/企管/",$tags[$class->class]))
                $tags[$class->class] = "企業管理系";
            else if(preg_match("/資管/",$tags[$class->class]))
                $tags[$class->class] = "資訊管理系";
            else if(preg_match("/國企/",$tags[$class->class]))
                $tags[$class->class] = "國際企業系";
            else if(preg_match("/財/",$tags[$class->class]))
                $tags[$class->class] = "財務金融系";
            else if(preg_match("/工管/",$tags[$class->class])||preg_match("/管/",$tags[$class->class]))
                $tags[$class->class] = "工業管理系";
            else if(preg_match("/應/",$tags[$class->class]))
                $tags[$class->class] = "應用外語系";
            else if(preg_match("/遊/",$tags[$class->class]))
                $tags[$class->class] = "多媒體與遊戲發展科學系";
            else if(preg_match("/觀/",$tags[$class->class]))
                $tags[$class->class] = "觀光休閒系";
            else if(preg_match("/文/",$tags[$class->class]))
                $tags[$class->class] = "文化創意與數位媒體設計系";
            else if((preg_match("/網/",$tags[$class->class]) && preg_match("/資網/",$tags[$class->class])||preg_match("/網/",$tags[$class->class])))
                $tags[$class->class] = "資訊網路工程系";
            else if(preg_match("/專班/",$tags[$class->class]))
                $tags[$class->class] = "PBL專班";
            else if(preg_match("/萬能/",$tags[$class->class]))
                $tags[$class->class] = "萬能";
            else if(preg_match("/羅東/",$tags[$class->class]))
                $tags[$class->class] = "羅東";
            else if(preg_match("/高苑/",$tags[$class->class]))
                $tags[$class->class] = "高苑";
            else if(preg_match("/海青/",$tags[$class->class]))
                $tags[$class->class] = "海青班";
            else if(preg_match("/國際學/",$tags[$class->class]))
                $tags[$class->class] = "國際學生";
            else if((preg_match("/4/",$tags[$class->class])||preg_match("/新南向/",$tags[$class->class])))
                $tags[$class->class] = "新南向(4+1)";
            else
                $tags[$class->class] = "其他";
        }
        $tags = array_unique($tags);
        $tags = array_diff($tags,["其他"]);
        return view("students.index",['classes'=>$tags,"students"=>$students,"showPagination"=>false,'select'=>1]);
    }

    public function studentID(Request $request){
        $students = Student::Where('number',$request->input('studentID'))->get();
        $classes = Student::allClasses()->get();
        $tags = [];
        foreach ($classes as $class)
        {
            $tags[$class->class] = $class->class;
            if(preg_match("/子/",$tags[$class->class]))
                $tags[$class->class] = "電子工程系";
            else if((preg_match("/電/",$tags[$class->class]) && preg_match("/電機/",$tags[$class->class]))||preg_match("/四電/",$tags[$class->class]))
                $tags[$class->class] = "電機工程系";
            else if(preg_match("/化材/",$tags[$class->class]))
                $tags[$class->class] = "化工與材料工程系";
            else if((preg_match("/機/",$tags[$class->class]) && preg_match("/機械/",$tags[$class->class])||preg_match("/機/",$tags[$class->class])))
                $tags[$class->class] = "機械工程系";
            else if(preg_match("/企管/",$tags[$class->class]))
                $tags[$class->class] = "企業管理系";
            else if(preg_match("/資管/",$tags[$class->class]))
                $tags[$class->class] = "資訊管理系";
            else if(preg_match("/國企/",$tags[$class->class]))
                $tags[$class->class] = "國際企業系";
            else if(preg_match("/財/",$tags[$class->class]))
                $tags[$class->class] = "財務金融系";
            else if(preg_match("/工管/",$tags[$class->class])||preg_match("/管/",$tags[$class->class]))
                $tags[$class->class] = "工業管理系";
            else if(preg_match("/應/",$tags[$class->class]))
                $tags[$class->class] = "應用外語系";
            else if(preg_match("/遊/",$tags[$class->class]))
                $tags[$class->class] = "多媒體與遊戲發展科學系";
            else if(preg_match("/觀/",$tags[$class->class]))
                $tags[$class->class] = "觀光休閒系";
            else if(preg_match("/文/",$tags[$class->class]))
                $tags[$class->class] = "文化創意與數位媒體設計系";
            else if((preg_match("/網/",$tags[$class->class]) && preg_match("/資網/",$tags[$class->class])||preg_match("/網/",$tags[$class->class])))
                $tags[$class->class] = "資訊網路工程系";
            else if(preg_match("/專班/",$tags[$class->class]))
                $tags[$class->class] = "PBL專班";
            else if(preg_match("/萬能/",$tags[$class->class]))
                $tags[$class->class] = "萬能";
            else if(preg_match("/羅東/",$tags[$class->class]))
                $tags[$class->class] = "羅東";
            else if(preg_match("/高苑/",$tags[$class->class]))
                $tags[$class->class] = "高苑";
            else if(preg_match("/海青/",$tags[$class->class]))
                $tags[$class->class] = "海青班";
            else if(preg_match("/國際學/",$tags[$class->class]))
                $tags[$class->class] = "國際學生";
            else if((preg_match("/4/",$tags[$class->class])||preg_match("/新南向/",$tags[$class->class])))
                $tags[$class->class] = "新南向(4+1)";
            else
                $tags[$class->class] = "其他";
        }
        $tags = array_unique($tags);
        $tags = array_diff($tags,["其他"]);
        return view("students.index",['classes'=>$tags,"students"=>$students,"showPagination"=>false,'select'=>1]);
    }

    public function class(Request $request)
    {
        if(preg_match("/子/",$request->input('class')))
            $class = "子";
        else if((preg_match("/電/",$request->input('class')) && preg_match("/電機/",$request->input('class')))||preg_match("/四電/",$request->input('class')))
            $class = "電";
        else if(preg_match("/化材/",$request->input('class')))
            $class = "化";
        else if((preg_match("/機/",$request->input('class')) && preg_match("/機械/",$request->input('class'))))
            $class = "機";
        else if(preg_match("/企管/",$request->input('class')))
            $class = "企管";
        else if(preg_match("/資管/",$request->input('class')))
            $class = "資管";
        else if(preg_match("/國企/",$request->input('class')))
            $class = "國企";
        else if(preg_match("/財/",$request->input('class')))
            $class = "財";
        else if(preg_match("/工管/",$request->input('class')))
            $class = "管";
        else if(preg_match("/應/",$request->input('class')))
            $class = "應";
        else if(preg_match("/遊/",$request->input('class')))
            $class = "遊";
        else if(preg_match("/觀/",$request->input('class')))
            $class = "觀";
        else if(preg_match("/文/",$request->input('class')))
            $class = "文";
        else if((preg_match("/網/",$request->input('class')) && preg_match("/資網/",$request->input('class'))))
            $class = "網";
        else if(preg_match("/專班/",$request->input('class')))
            $class = "專班";
        else if(preg_match("/萬能/",$request->input('class')))
            $class = "萬能";
        else if(preg_match("/羅東/",$request->input('class')))
            $class = "羅東";
        else if(preg_match("/高苑/",$request->input('class')))
            $class = "高苑";
        else if(preg_match("/海青/",$request->input('class')))
            $class = "海青";
        else if(preg_match("/國際學/",$request->input('class')))
            $class = "國際學";
        else if((preg_match("/4/",$request->input('class'))||preg_match("/新南向/",$request->input('class'))))
            $class = "新南向";
        $students = Student::class($class)->get();
        $classes = Student::allClasses()->get();
        $tags = [];
        foreach ($classes as $class)
        {
            $tags[$class->class] = $class->class;
            if(preg_match("/子/",$tags[$class->class]))
                $tags[$class->class] = "電子工程系";
            else if((preg_match("/電/",$tags[$class->class]) && preg_match("/電機/",$tags[$class->class]))||preg_match("/四電/",$tags[$class->class]))
                $tags[$class->class] = "電機工程系";
            else if(preg_match("/化材/",$tags[$class->class]))
                $tags[$class->class] = "化工與材料工程系";
            else if((preg_match("/機/",$tags[$class->class]) && preg_match("/機械/",$tags[$class->class])||preg_match("/機/",$tags[$class->class])))
                $tags[$class->class] = "機械工程系";
            else if(preg_match("/企管/",$tags[$class->class]))
                $tags[$class->class] = "企業管理系";
            else if(preg_match("/資管/",$tags[$class->class]))
                $tags[$class->class] = "資訊管理系";
            else if(preg_match("/國企/",$tags[$class->class]))
                $tags[$class->class] = "國際企業系";
            else if(preg_match("/財/",$tags[$class->class]))
                $tags[$class->class] = "財務金融系";
            else if(preg_match("/工管/",$tags[$class->class])||preg_match("/管/",$tags[$class->class]))
                $tags[$class->class] = "工業管理系";
            else if(preg_match("/應/",$tags[$class->class]))
                $tags[$class->class] = "應用外語系";
            else if(preg_match("/遊/",$tags[$class->class]))
                $tags[$class->class] = "多媒體與遊戲發展科學系";
            else if(preg_match("/觀/",$tags[$class->class]))
                $tags[$class->class] = "觀光休閒系";
            else if(preg_match("/文/",$tags[$class->class]))
                $tags[$class->class] = "文化創意與數位媒體設計系";
            else if((preg_match("/網/",$tags[$class->class]) && preg_match("/資網/",$tags[$class->class])||preg_match("/網/",$tags[$class->class])))
                $tags[$class->class] = "資訊網路工程系";
            else if(preg_match("/專班/",$tags[$class->class]))
                $tags[$class->class] = "PBL專班";
            else if(preg_match("/萬能/",$tags[$class->class]))
                $tags[$class->class] = "萬能";
            else if(preg_match("/羅東/",$tags[$class->class]))
                $tags[$class->class] = "羅東";
            else if(preg_match("/高苑/",$tags[$class->class]))
                $tags[$class->class] = "高苑";
            else if(preg_match("/海青/",$tags[$class->class]))
                $tags[$class->class] = "海青班";
            else if(preg_match("/國際學/",$tags[$class->class]))
                $tags[$class->class] = "國際學生";
            else if((preg_match("/4/",$tags[$class->class])||preg_match("/新南向/",$tags[$class->class])))
                $tags[$class->class] = "新南向(4+1)";
            else
                $tags[$class->class] = "其他";
        }
        $tags = array_unique($tags);
        $tags = array_diff($tags,["其他"]);
        return view("students.index",["students"=>$students,'classes'=>$tags,"showPagination"=>false,'select'=>$request->input('class')]);
    }

    public function create(){
        return view("students.create",['showphoto'=>0]);
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

        if($file != null){
            $file->move($destinationPath,"$name.".$file->getClientOriginalExtension());
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
        }
        else{
            $student = Student::create([
                'profile_file_path'=>"",
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
        }
        
        // 新增學生資料時順便建立帳號
        $password = Hash::make($number);
        $user = User::create([
            'sid' => $student->id,
            'name' => $name,
            'email' => "$number@gm.lhu.edu.tw",
            'password' => $password
        ]);
        return redirect("students");
    }
    public function edit($id){
        $student = Student::findOrFail($id);
        return view('students.edit',['student'=>$student,'showphoto'=>1]);
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

        if($request->hasFile('profile')){
            $file = $request->file('profile');
            $destinationPath = 'storage/uploads/profiles/'.$student->name;
            $file->move($destinationPath,"$student->name.".$file->getClientOriginalExtension());
            $student->profile_file_path = $destinationPath."/$student->name.".$file->getClientOriginalExtension();
        }
        
        $student->save();
        return redirect('students');
    }
}
