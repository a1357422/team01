<?php

namespace App\Imports;

use App\Models\Bed;
use App\Models\Sbrecord;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;  //指定檔案標題列的格式
HeadingRowFormatter::default('none'); //一定要加 不然讀不到中文

class StudentsImport implements ToCollection ,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){
        foreach ($rows as $row) {
            if(!(isset($row['學號'])))
                continue;
            else{
                $count = Student::where('number',$row['學號'])->count();
                if($count > 0 || $row['學號']==null)
                    continue;
                else{
                    if(strlen(strval($row['手機']))==9)
                        $row['手機']="0".strval($row['手機']);
                    else if (strlen(strval($row['手機']))>10){
                        $row['手機'] = str_replace('-','',strval($row['手機']));
                    }
                    if(!(is_string($row['備註'])) && $row['備註'] != null){
                        $row['備註'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['備註'])->format('Y-m-d');
                    }
                    if($row['姓名']==null)
                        $name = "無";
                    else
                        $name = $row['姓名'];
                    if($row['班級']==null)
                        $class = "無";
                    else
                        $class = $row['班級'];
                    if($row['家長姓名'] == null)
                        $guardian = "無";
                    else
                        $guardian = $row['家長姓名'];
                    if($row['關係']== null)
                        $salutation = "無";
                    else
                        $salutation = $row['關係'];
                    $row['學號'] = ucfirst($row['學號']);
                    $student = Student::create([
                        'number' => $row['學號'],
                        'class' => $class, 
                        'name' => $name,
                        'address' => $row['地址'],
                        'phone' => $row['手機'],
                        'nationality' => $row['國籍'],
                        'guardian' => $guardian,
                        'salutation' => $salutation,
                        'remark' => $row['備註'],
                    ]);
                    $password = Hash::make($row['學號']);
                    $user = User::create([
                        'sid' => $student->id,
                        'name' => $name,
                        'email' => $row['學號']."@gm.lhu.edu.tw",
                        'password' => $password
                    ]);
                    $sid = $student->id;
                    if($row['81 - 房號']!=null){
                        $bed = Bed::where('bedcode',$row['81 - 房號'])->first();
                        if(isset($bed->id)){
                            $bid = $bed->id;
                            Sbrecord::create([
                                'school_year' => 111,
                                'semester' => 2,
                                'sid' => $sid,
                                'bid' => $bid
                            ]);
                        }
                    }
                    else if($row['82 - 房號']!=null){
                        $bed = Bed::where('bedcode',$row['82 - 房號'])->first();
                        if(isset($bed->id)){
                            $bid = $bed->id;
                            Sbrecord::create([
                                'school_year' => 111,
                                'semester' => 2,
                                'sid' => $sid,
                                'bid' => $bid
                            ]);
                        }
                    }
                    else if($row['83 - 房號']!=null){
                        $bed = Bed::where('bedcode',$row['83 - 房號'])->first();
                        if(isset($bed->id)){
                            $bid = $bed->id;
                            Sbrecord::create([
                                'school_year' => 111,
                                'semester' => 2,
                                'sid' => $sid,
                                'bid' => $bid
                            ]);
                        }
                    }
                    
                }
            }
        }
    }
    public function headingRow(): int {
        return 1;
    }
}
