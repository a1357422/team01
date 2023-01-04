<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Sbrecord;
use App\Models\Bed;
// use Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateFeatureRequest;

class FeaturesController extends Controller
{
    public function index(){
        $features = Feature::paginate(10);
        $dormitories = Bed::allDormitories()->get();
        
        $tags = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $tags["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $tags["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $tags["$dormitory->did"] = "男一宿";
            }
            else{
                $tags["$dormitory->did"] = "涵青館";
            }
        }

        return view("features.index",['display'=>1,"features"=>$features,'dormitories'=>$tags,"showPagination"=>True,'select'=>1]);
    }


    public function api_features()
    {
        return Feature::all();
    }

    public function api_update(Request $request)
    {
        $feature = Feature::find($request->input('id'));
        if ($feature == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        $feature->sbid = $request->input('sbid');
        $feature->path = $request->input('path');
        $feature->feature = $request->input('feature');

        if ($feature->save())
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
        $feature = Feature::find($request->input('id'));

        if ($feature == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($feature->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
    }

    public function show($id){
        $feature = Feature::findOrFail($id);
        return view("features.show",["feature"=>$feature]);
    }

    public function dormitory(Request $request)
    {
        $features = Feature::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
        $tags = [];
        foreach ($dormitories as $dormitory)
        {
            if($dormitory->did == "1"){
                $tags["$dormitory->did"] = "女一宿";
            }
            else if($dormitory->did == "2"){
                $tags["$dormitory->did"] = "女二宿";
            }
            else if($dormitory->did == "3"){
                $tags["$dormitory->did"] = "男一宿";
            }
            else{
                $tags["$dormitory->did"] = "涵青館";
            }
        }
        return view("features.index",['display'=>2,"features"=>$features,'dormitories'=>$tags,"showPagination"=>false,'select'=>$request->input('dormitory')]);
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