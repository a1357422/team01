<?php

use App\Http\Controllers\BedsController;
use App\Http\Controllers\DormitoriesController;
use App\Http\Controllers\LatesController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\RollcallsController;
use App\Http\Controllers\SbrecordsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Homepage
// Route::get('/', function () {
//     return redirect('students');
// });

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return redirect('login');
// });

//顯示所有學生資料
Route::get('students',[StudentsController::class,'index'])->name('students.index');
//新增學生資料表單
Route::get('students/create',[StudentsController::class,'create'])->name('students.create');
//顯示一筆學生詳細資料
Route::get('students/{id}',[StudentsController::class,'show'])->where("id","[0-9]+")->name('students.show');
//刪除一筆學生資料
Route::delete('students/delete/{id}',[StudentsController::class,'destroy'])->where("id","[0-9]+")->name('students.destroy');
//新增一筆學生資料
Route::post('students/store',[StudentsController::class,'store'])->name('students.store');
//修改學生資料表單
Route::get('students/{id}/edit',[StudentsController::class,'edit'])->where("id","[0-9]+")->name('students.edit');
//修改一筆學生資料
Route::patch('students/update/{id}',[StudentsController::class,'update'])->where("id","[0-9]+")->name('students.update');
//顯示下拉式選單所選系別的學生資料
Route::post('students/class', [StudentsController::class,'class'])->name('students.class');

Route::get('dormitories',[DormitoriesController::class,'index'])->name('dormitories.index');
Route::get('dormitories/create',[DormitoriesController::class,'create'])->name('dormitories.create');
Route::get('dormitories/{id}',[DormitoriesController::class,'show'])->where("id","[0-9]+")->name('dormitories.show');
Route::delete('dormitories/delete/{id}',[DormitoriesController::class,'destroy'])->where("id","[0-9]+")->name('dormitories.destroy');
Route::post('dormitories/store',[DormitoriesController::class,'store'])->name('dormitories.store');
Route::get('dormitories/{id}/edit',[DormitoriesController::class,'edit'])->where("id","[0-9]+")->name('dormitories.edit');
Route::patch('dormitories/update/{id}',[DormitoriesController::class,'update'])->where("id","[0-9]+")->name('dormitories.update');

Route::get('beds',[BedsController::class,'index'])->name('beds.index');
Route::post('beds/dormitory', [BedsController::class, 'dormitory'])->name('beds.dormitory');
Route::get('beds/create',[BedsController::class,'create'])->name('beds.create');
Route::get('beds/{id}',[BedsController::class,'show'])->where("id","[0-9]+")->name('beds.show');
Route::delete('beds/delete/{id}',[BedsController::class,'destroy'])->where("id","[0-9]+")->name('beds.destroy');
Route::post('beds/store',[BedsController::class,'store'])->name('beds.store');
Route::get('beds/{id}/edit',[BedsController::class,'edit'])->where("id","[0-9]+")->name('beds.edit');
Route::patch('beds/update/{id}',[BedsController::class,'update'])->where("id","[0-9]+")->name('beds.update');

Route::get('sbrecords',[SbrecordsController::class,'index'])->name('sbrecords.index');
Route::get('sbrecords/senior',[SbrecordsController::class,'senior'])->name('sbrecords.senior');
Route::get('sbrecords/create',[SbrecordsController::class,'create'])->name('sbrecords.create');
Route::get('sbrecords/{id}',[SbrecordsController::class,'show'])->where("id","[0-9]+")->name('sbrecords.show');
Route::delete('sbrecords/delete/{id}',[SbrecordsController::class,'destroy'])->where("id","[0-9]+")->name('sbrecords.destroy');
Route::post('sbrecords/store',[SbrecordsController::class,'store'])->name('sbrecords.store');
Route::get('sbrecords/{id}/edit',[SbrecordsController::class,'edit'])->where("id","[0-9]+")->name('sbrecords.edit');
Route::patch('sbrecords/update/{id}',[SbrecordsController::class,'update'])->where("id","[0-9]+")->name('sbrecords.update');
Route::post('sbrecords/dormitory', [SbrecordsController::class,'dormitory'])->name('sbrecords.dormitory');

Route::get('rollcalls',[RollcallsController::class,'index'])->name('rollcalls.index');
Route::get('rollcalls/create',[RollcallsController::class,'create'])->name('rollcalls.create');
Route::get('rollcalls/{id}',[RollcallsController::class,'show'])->where("id","[0-9]+")->name('rollcalls.show');
Route::delete('rollcalls/delete/{id}',[RollcallsController::class,'destroy'])->where("id","[0-9]+")->name('rollcalls.destroy');
Route::post('rollcalls/store',[RollcallsController::class,'store'])->name('rollcalls.store');
Route::get('rollcalls/{id}/edit',[RollcallsController::class,'edit'])->where("id","[0-9]+")->name('rollcalls.edit');
Route::patch('rollcalls/update/{id}',[RollcallsController::class,'update'])->where("id","[0-9]+")->name('rollcalls.update');
Route::post('rollcalls/dormitory', [RollcallsController::class,'dormitory'])->name('rollcalls.dormitory');


Route::get('lates',[LatesController::class,'index'])->name('lates.index');
Route::get('lates/create',[LatesController::class,'create'])->name('lates.create');
Route::get('lates/{id}',[LatesController::class,'show'])->where("id","[0-9]+")->name('lates.show');
Route::get('lates/examine/{id}',[LatesController::class,'examine'])->where("id","[0-9]+")->name('lates.examine');
Route::delete('lates/delete/{id}',[LatesController::class,'destroy'])->where("id","[0-9]+")->name('lates.destroy');
Route::post('lates/store',[LatesController::class,'store'])->name('lates.store');
Route::get('lates/{id}/edit',[LatesController::class,'edit'])->where("id","[0-9]+")->name('lates.edit');
Route::patch('lates/update/{id}',[LatesController::class,'update'])->where("id","[0-9]+")->name('lates.update');
Route::post('lates/dormitory', [LatesController::class,'dormitory'])->name('lates.dormitory');

Route::get('leaves',[LeavesController::class,'index'])->name('leaves.index');
Route::get('leaves/create',[LeavesController::class,'create'])->name('leaves.create');
Route::get('leaves/{id}',[LeavesController::class,'show'])->where("id","[0-9]+")->name('leaves.show');
Route::get('leaves/examine/{id}',[LeavesController::class,'examine'])->where("id","[0-9]+")->name('leaves.examine');
Route::delete('leaves/delete/{id}',[LeavesController::class,'destroy'])->where("id","[0-9]+")->name('leaves.destroy');
Route::post('leaves/store',[LeavesController::class,'store'])->name('leaves.store');
Route::get('leaves/{id}/edit',[LeavesController::class,'edit'])->where("id","[0-9]+")->name('leaves.edit');
Route::patch('leaves/update/{id}',[LeavesController::class,'update'])->where("id","[0-9]+")->name('leaves.update');
Route::post('leaves/dormitory', [LeavesController::class,'dormitory'])->name('leaves.dormitory');

Route::get('features',[FeaturesController::class,'index'])->name('features.index');
Route::get('features/create',[FeaturesController::class,'create'])->name('features.create');
Route::get('features/{id}',[FeaturesController::class,'show'])->where("id","[0-9]+")->name('features.show');
Route::delete('features/delete/{id}',[FeaturesController::class,'destroy'])->where("id","[0-9]+")->name('features.destroy');
Route::post('features/store',[FeaturesController::class,'store'])->name('features.store');
Route::get('features/{id}/edit',[FeaturesController::class,'edit'])->where("id","[0-9]+")->name('features.edit');
Route::patch('features/update/{id}',[FeaturesController::class,'update'])->where("id","[0-9]+")->name('features.update');
Route::post('features/dormitory', [FeaturesController::class,'dormitory'])->name('features.dormitory');

Route::get('users',[UsersController::class,'index'])->name('users.index');
Route::get('users/{id}/edit',[UsersController::class,'edit'])->where("id","[0-9]+")->name('users.edit');
Route::patch('users/update/{id}',[UsersController::class,'update'])->where("id","[0-9]+")->name('users.update');



Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
