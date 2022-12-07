<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Sbrecord;
use Request;
use Illuminate\Support\Facades\DB;

class FeaturesController extends Controller
{
    public function index(){
        $features = Feature::paginate(10);
        return view("features.index",["features"=>$features]);
    }

    public function show($id){
        $feature = Feature::findOrFail($id);
        return view("features.show",["feature"=>$feature]);
    }

    public function destroy($id){
        $feature = Feature::findOrFail($id);
        $feature->delete();
        return redirect("features");
    }
    
    public function create(){
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.sid', 'sbrecords.id');
        return view("features.create",['sbrecords'=>$sbrecords]);
    }

    public function store(){
        $input = Request::all();
        Feature::create($input);
        return redirect("features");
    }

    public function edit($id){
        $feature = Feature::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.sid', 'sbrecords.id');
        $selectSbid = $feature->sbid;
        return view('features.edit',['feature'=>$feature,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid]);
    }

    public function update($id){
        $input = Request::all();
        $feature = Feature::findOrFail($id);

        $feature->sbid = $input['date'];
        $feature->path = $input['sbid'];
        $feature->feature = $input['presence'];

        $feature->save();
        return redirect('features');
    }
}