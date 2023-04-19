<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function index(){
        $users = User::name()->paginate(10);
        $roles = User::allRoles()->get();
        $tags = [];
        foreach ($roles as $role)
        {
            if($role->role == "floorhead")
                $tags["$role->role"] = "樓長";
            else if($role->role == "chief")
                $tags["$role->role"] = "總樓長";
            else if($role->role == "housemaster")
                $tags["$role->role"] = "宿舍輔導員";
            else if($role->role == "admin")
                $tags["$role->role"] = "宿舍行政";
            else if($role->role == "superadmin")
                $tags["$role->role"] = "系統後台管理員";
            else
                $tags["$role->role"] = "住宿生";
        }

        return view("users.index",['users'=>$users,'roles'=>$tags,"showPagination"=>True,'select'=>1]);
    }

    public function role(Request $request){
        $users = User::role($request->input('role'))->get();

        $roles = User::allRoles()->get();
        $tags = [];
        foreach ($roles as $role)
        {
            if($role->role == "floorhead")
                $tags["$role->role"] = "樓長";
            else if($role->role == "chief")
                $tags["$role->role"] = "總樓長";
            else if($role->role == "housemaster")
                $tags["$role->role"] = "宿舍輔導員";
            else if($role->role == "admin")
                $tags["$role->role"] = "宿舍行政";
            else if($role->role == "superadmin")
                $tags["$role->role"] = "系統後台管理員";
            else
                $tags["$role->role"] = "住宿生";
        }
        return view('users.index', ['users' => $users, 'roles'=>$tags,"showPagination"=>False,'select'=>$request->input('role')]);
    }
    public function edit($id){
        $user = User::findOrFail($id);
        $roles = User::allRoles()->get();
        $tags = [];
        foreach ($roles as $role)
        {
            if($role->role == "superadmin")
                $tags["$role->role"] = "系統後台管理者";
            else if($role->role == "housemaster")
                $tags["$role->role"] = "宿舍輔導員";
            else if($role->role == "admin")
                $tags["$role->role"] = "宿舍行政";
            else if($role->role == "chief")
                $tags["$role->role"] = "總樓長";
            else if($role->role == "floorhead")
                $tags["$role->role"] = "樓長";
            else
                $tags["$role->role"] = "住宿生";
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
