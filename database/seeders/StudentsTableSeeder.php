<?php

namespace Database\Seeders;

use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function generateRandomNumberString($length = 10) {
        $numbers = "0123456789";
        $numbersLength = strlen($numbers);
        $randomNumberString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumberString .= $numbers[rand(0, $numbersLength - 1)];
        }
        return $randomNumberString;
    }

    public function StudentIDCreate($length = 10) {
        // $numbers = "";
        // $numbers .= generateRandomString(1).generateRandomNumberString();
        // return ucfirst($numbers);
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $numbers = "0123456789";
        $numbersLength = strlen($numbers);
        $randomString = '';
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $numbers[rand(0, $numbersLength - 1)];
        }
        return ucfirst($randomString);
    }
    
    public function generateRandomClass() {
        $majors = ['資網', '電子', '電機', '化材', '機械', '企管','資管',"國企","財金","工管","應外","遊戲","觀光","文創"];
        $levels = ['一','二','三','四'];
        $class = ['A','B','C','D'];
        $info ="";
        $info .= $majors[rand(0, count($majors)-1)] . $levels[rand(0, count($levels)-1)] . $class[rand(0, count($class)-1)];
        return $info;
    }
    public function generateRandomName() {
        $first_name = $this->generateRandomString(rand(2, 15));
        $first_name = strtolower($first_name);
        $first_name = ucfirst($first_name);
        $last_name = $this->generateRandomString(rand(2, 15));
        $last_name = strtolower($last_name);
        $last_name = ucfirst($last_name);
        $name = $first_name . " ". $last_name;
        return $name;
    }
    public function generateRandomPhone() {
        $area_codes = "09";
        $code = $this->generateRandomNumberString(8);
        $phone = $area_codes . $code;
        return $phone;
    }

    public function generateRandomNationality() {
        $positions = ['美國', '土耳其', '法國', '印度', '非洲', '中國', '塞爾維亞', '英國', '台灣'];
        return $positions[rand(0, count($positions)-1)];
    }

    public function generateRandomRelation() {
        $Relation = ['父','母'];
        return $Relation[rand(0, count($Relation)-1)];
    }

    public function run()
    {
        //
        for ($i=0;$i<1252;$i++){
            if($i == 972){
                DB::table('students')->insert([
                    'number' => "D1094162012",
                    'class' => "資網三B",
                    'name' => "簡至昊",
                    'address' => "桃園市龜山區萬壽路一段300號",
                    'phone' => "0282093211",
                    'nationality' => "台灣",
                    'guardian' => "xxx",
                    'salutation' => "父",
                    'remark' => ""
                ]);
                DB::table('users')->insert([
                    'sid' => 973,
                    'name' =>"簡至昊",
                    'email' => "D1094162012@gm.lhu.edu.tw",
                    'password' => Hash::make("D1094162012")
                ]);
                $i+=1;
            }
            if($i == 975){
                DB::table('students')->insert([
                    'number' => "D1094182042",
                    'class' => "資網三B",
                    'name' => "羅銘麒",
                    'address' => "桃園市龜山區萬壽路一段300號",
                    'phone' => "0282093211",
                    'nationality' => "台灣",
                    'guardian' => "xxx",
                    'salutation' => "父",
                    'remark' => ""
                ]); 
                DB::table('users')->insert([
                    'sid' => 976,
                    'name' =>"羅銘麒",
                    'email' => "D1094182042@gm.lhu.edu.tw",
                    'password' => Hash::make("D1094182042")
                ]);
            }
            else{
                $number = $this->StudentIDCreate();
                $class = $this->generateRandomClass();
                $name = $this->generateRandomName();
                $address = $this->generateRandomName(15);
                $phone = $this->generateRandomPhone();
                $guardian = $this->generateRandomName();
                $nationality = $this->generateRandomNationality();
                $salutation = $this->generateRandomRelation();
                $password = Hash::make($number);

                DB::table('students')->insert([
                    'number' => $number,
                    'class' => $class,
                    'name' => $name,
                    'address' => $address,
                    'phone' => $phone,
                    'nationality' => $nationality,
                    'guardian' => $guardian,
                    'salutation' => $salutation,
                    'remark' => ""
                ]); 

                DB::table('users')->insert([
                    'sid' => $i+1,
                    'name' => $name,
                    'email' => "$number@gm.lhu.edu.tw",
                    'password' => $password
                ]);
            }
            
        }
    }
}