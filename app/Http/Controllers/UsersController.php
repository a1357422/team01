<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function index(){
        $users = User::paginate(10);
        $roles = User::allRoles()->get();
        $tags = [];
        foreach ($roles as $role)
        {
            if($role->role == "floorhead"){
                $tags["$role->role"] = "樓長";
            }
            else if($role->role == "chief"){
                $tags["$role->role"] = "總樓長";
            }
            else if($role->role == "housemaster"){
                $tags["$role->role"] = "宿舍輔導員";
            }
            else if($role->role == "admin"){
                $tags["$role->role"] = "宿舍行政";
            }
            else if($role->role == "superadmin"){
                $tags["$role->role"] = "系統後台管理員";
            }
            else{
                $tags["$role->role"] = "住宿生";
            }
        }

        return view("users.index",['users'=>$users,'roles'=>$tags,"showPagination"=>True,'select'=>1]);
    }

    public function role(Request $request){
        $users = User::role($request->input('role'))->get();

        $roles = User::allRoles()->get();
        $tags = [];
        foreach ($roles as $role)
        {
            if($role->role == "floorhead"){
                $tags["$role->role"] = "樓長";
            }
            else if($role->role == "chief"){
                $tags["$role->role"] = "總樓長";
            }
            else if($role->role == "housemaster"){
                $tags["$role->role"] = "宿舍輔導員";
            }
            else if($role->role == "admin"){
                $tags["$role->role"] = "宿舍行政";
            }
            else if($role->role == "superadmin"){
                $tags["$role->role"] = "系統後台管理員";
            }
            else{
                $tags["$role->role"] = "住宿生";
            }
        }

        return view('users.index', ['users' => $users, 'roles'=>$tags,"showPagination"=>False,'select'=>$request->input('role')]);
    }

    public function api_users()
    {
        return User::all();
    }

    public function api_update(Request $request)
    {
        $user = User::find($request->input('id'));
        if ($user == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }
        
        if($request->input('role') == "系統後台管理員"){
            $user->role = "superadmin";
        }
        else if($request->input('role') == "宿舍輔導員"){
            $user->role = "housemaster";
        }
        else if($request->input('role') == "宿舍行政"){
            $user->role = "admin";
        }
        else if($request->input('role') == "總樓長"){
            $user->role = "chief";
        }
        else if($request->input('role') == "樓長"){
            $user->role = "floorhead";
        }
        else{
            $user->role = "user";
        }

        if ($user->save())
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
        $user = User::find($request->input('id'));

        if ($user == null)
        {
            return response()->json([
                'status' => 0,
            ]);
        }

        if ($user->delete())
        {
            return response()->json([
                'status' => 1,
            ]);
        }
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $roles = User::allRoles()->get();
        $tags = [];
        foreach ($roles as $role)
        {
            if($role->role == "superadmin"){
                $tags["$role->role"] = "系統後台管理者";
            }
            else if($role->role == "housemaster"){
                $tags["$role->role"] = "宿舍輔導員";
            }
            else if($role->role == "admin"){
                $tags["$role->role"] = "宿舍行政";
            }
            else if($role->role == "chief"){
                $tags["$role->role"] = "總樓長";
            }
            else if($role->role == "floorhead"){
                $tags["$role->role"] = "樓長";
            }
            else{
                $tags["$role->role"] = "住宿生";
            }
        }
        return view('users.edit',['user'=>$user,'roles'=>$tags]);
    }
    public function update($id,Request $request){
        $users = User::findOrFail($id);

        $users->role = $request->input('role');

        $users->save();
        return redirect('users');
    }
}
