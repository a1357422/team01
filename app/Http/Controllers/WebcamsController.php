<?php
    
namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Rollcall;
use App\Models\Sbrecord;
use App\Models\Webcam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

  
class WebcamsController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function upload($id)
    {
        $sbrecord=Sbrecord::findOrFail($id);
        return view('webcams.upload',["sbrecord"=>$sbrecord]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $sbrecords = Sbrecord::get();
        $rollcalls = Rollcall::Dormitory($request->input('dormitory'))->get();
        $dormitories = Bed::allDormitories()->get();
        $tags = [];
        $date = date("md");
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

        $img = $request->image;
        if($img!=null){
            $folderPath = "uploads/".$date."_".$request->input('name')."/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            
            $image_base64 = base64_decode($image_parts[1]);
            // $fileName = uniqid() . '.png';
            $fileName = $request->input('name');
            
            $file = $folderPath . $fileName.'.png';
            Storage::put($file, $image_base64);

            return view("rollcalls/create",["dormitories"=>$tags,"select"=>1,"selectfloor"=>1,"display"=>1,"sbrecords"=>$sbrecords,"date"=>$date,"file_name"=>$fileName,"bedcode"=>$request->input('bedcode')]);
        }
        else{
            return redirect("rollcalls/create");
        }
        
    }
}