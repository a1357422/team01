<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Request;
use App\Http\Requests\CreateDormitoryRequest;
use App\Models\Dormitory;
use Illuminate\Http\Request;

class DormitoriesController extends Controller
{
    //
    public function index(){
        $dormitories = Dormitory::paginate(10);
        return view("dormitories.index",["dormitories"=>$dormitories]);
    }

    public function show($id){
        $dormitory = Dormitory::findOrFail($id);
        $beds = $dormitory->beds;
        return view("dormitories.show",["dormitory"=>$dormitory,"beds"=>$beds]);
    }

    public function destroy($id){
        $dormitory = Dormitory::findOrFail($id);
        $dormitory->delete();
        return redirect("dormitories");
    }
    public function create(){
        return view("dormitories.create");
    }
    public function store(CreateDormitoryRequest $request){
        $name = $request->input('name');
        $housemaster = $request->input('housemaster');
        $contact = $request->input('contact');

        $dormitory = Dormitory::create([
            'name' => $name,
            'housemaster' => $housemaster,
            'contact' => $contact,
        ]);

        return redirect("dormitories");
    }
    public function edit($id){
        $dormitory = Dormitory::findOrFail($id);
        return view('dormitories.edit',['dormitory'=>$dormitory]);
    }
    public function update($id,CreateDormitoryRequest $request){
        $dormitory = Dormitory::findOrFail($id);

        $dormitory->name = $request->input('name');
        $dormitory->housemaster = $request->input('housemaster');
        $dormitory->contact = $request->input('contact');

        $dormitory->save();
        return redirect('dormitories');
    }
}
