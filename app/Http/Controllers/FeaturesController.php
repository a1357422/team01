<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Sbrecord;
// use Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateFeatureRequest;

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
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        return view("features.create",['sbrecords'=>$sbrecords]);
    }

    public function store(CreateFeatureRequest $request){
        $sbid = $request->input('sbid');
        $path = $request->input('path');
        $feature = $request->input('feature');

        $feature = Feature::create([
            'sbid' => $sbid,
            'path' => $path,
            'feature' => $feature,
        ]);
        return redirect("features");
    }

    public function edit($id){
        $feature = Feature::findOrFail($id);
        $sbrecords = Sbrecord::orderBy('sbrecords.id', 'asc')->pluck('sbrecords.id', 'sbrecords.id');   //隨sbrecord之id
        $selectSbid = $feature->sbid;
        return view('features.edit',['feature'=>$feature,'sbrecords'=>$sbrecords,'selectSbid'=>$selectSbid]);
    }

    public function update($id,CreateFeatureRequest $request){
        $feature = Feature::findOrFail($id);

        $feature->sbid = $request->input('sbid');
        $feature->path = $request->input('path');
        $feature->feature = $request->input('feature');

        $feature->save();
        return redirect('features');
    }
}