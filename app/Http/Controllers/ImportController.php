<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //

    public function index(){
        return view("imports.index");
    }


    public function uploadExcel(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new StudentsImport,$path);
        return redirect()->back()->with('success', '檔案匯入成功。');
    }
}
