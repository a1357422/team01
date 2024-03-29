<?php

namespace Database\Seeders;

use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $password = Hash::make('00000000');
            DB::table('users')->insert([
                'sid' => 9999,
                'name' => "系統後臺管理員",
                'role' => "superadmin",
                'email' => "superadmin@gmail.com",
                'password' => $password
            ]);
            DB::table('users')->insert([
                'sid' => 9998,
                'name' => "宿舍輔導員",
                'role' => "housemaster",
                'email' => "housemaster@gmail.com",
                'password' => $password
            ]);
            DB::table('users')->insert([
                'sid' => 9997,
                'name' => "宿舍行政",
                'role' => "admin",
                'email' => "admin@gmail.com",
                'password' => $password
            ]);
            DB::table('users')->insert([
                'sid' => 9996,
                'name' => "總樓長",
                'role' => "chief",
                'email' => "chief@gmail.com",
                'password' => $password
            ]);
            DB::table('users')->insert([
                'sid' => 9995,
                'name' => "樓長",
                'role' => "floorhead",
                'email' => "floorhead@gmail.com",
                'password' => $password
            ]);
            DB::table('users')->insert([
                'sid' => 9994,
                'name' => "住宿生",
                'email' => "user@gmail.com",
                'password' => $password
            ]);
        }
}