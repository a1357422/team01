<?php

namespace App\Http\Controllers;

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
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path)->get();

            if ($data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'column1' => $value->column1,
                        'column2' => $value->column2,
                        // ...
                    ];
                }

                if (!empty($insert)) {
                    return redirect()->back()->with('success', '資料已成功匯入！');
                }
            }
        }

        return redirect()->back()->with('error', '檔案匯入失敗，請再試一次。');
    }
}
