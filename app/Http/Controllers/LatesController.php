<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Sbrecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LatesController extends Controller
{
    //
    public function index(){
        $lates = Late::all();
        return view("lates.index",["lates"=>$lates]);
    }
    public function show($id){
        $late = Late::findOrFail($id);

        return view('lates.show', ['late' => $late]);
    }
    public function examine($id){
        $late = Late::findOrFail($id);

        return view('lates.examine', ['late' => $late]);
    }
    public function destroy($id){
        $late = Late::findOrFail($id);
        $late->delete();
        return redirect('lates');
    }
    public function create(){
        $sbrecord = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.sid', 'sbrecords.id');
        return view("lates.create",['sbrecords'=>$sbrecord]);
    }
    public function store(){
        $input = Request::all();
        Late::create($input);
        return redirect("lates");
    }
    public function edit($id){
        return view('lates.edit');
    }
}
