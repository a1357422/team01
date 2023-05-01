<?php

namespace App\Imports;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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
                Student::create([
                    'number' => $row['學號'],
                    'class' => $class, 
                    'name' => $row['姓名'],
                    'address' => $row['地址'],
                    'phone' => $row['手機'],
                    'nationality' => $row['國籍'],
                    'guardian' => $guardian,
                    'salutation' => $salutation,
                    'remark' => $row['備註'],
                ]);
            }
        }
    }
    public function headingRow(): int {
        return 1;
    }
}
