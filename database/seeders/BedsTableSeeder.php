<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedsTableSeeder extends Seeder
{
    public $linkStr = "";
    public function generateRandomBedcode($length = 2) {
        $domitorycode = ["81","82","83"];
        $floorcode_girl1 = '3567';
        $floorcode_boy1andgirl2 = '12345';
        $floorcode_boy3 = '3456';

        $bedcode = '-01234567';
        $bedcodelength = strlen($bedcode);
        $randomString = "";
        $bedcodeString = $domitorycode[rand(0,count($domitorycode)-1)];

        for ($i = 0; $i < $length; $i++) { 
            if ($i == 0 && $bedcodeString==81){
                $randomString .= $floorcode_girl1[rand(0, strlen($floorcode_girl1) - 1)]."0".rand(1,9);
            }
            else if ($i == 0 && $bedcodeString==82){
                $floorcode_boy1andgirl2 = $floorcode_boy1andgirl2[rand(0, strlen($floorcode_boy1andgirl2) - 1)];
                $randomString .= $floorcode_boy1andgirl2;
                if ($floorcode_boy1andgirl2=="1"){
                    if(rand(1,28)/10<1)
                        $randomString.="0".rand(4,9);
                    else 
                        if (rand(10,28)<12)
                            $randomString.=rand(10,11);
                        else 
                            $randomString.=rand(12,28);
                }
                else if ($floorcode_boy1andgirl2=="2"){
                    if(rand(1,32)/10<1)
                        $randomString.="0".rand(1,9);
                    else 
                        if (rand(10,28)<15)
                            $randomString.=rand(10,14);
                        else 
                            $randomString.=rand(15,32);
                }
                else {
                    if(rand(1,32)/10<1)
                        $randomString.="0".rand(1,9);
                    else 
                        $randomString.=rand(10,32);
                }

            }
            else if ($i == 0 && $bedcodeString==83){
                $randomString .= $floorcode_boy3[rand(1, strlen($floorcode_boy3) - 1)];
                if(rand(1,39)/10<1)
                    $randomString.="0".rand(1,9);
                else
                    $randomString.=rand(10,39);
            }
            else if ($i == 1)
                if($bedcodeString==81)
                    $randomString .= $bedcode[0].rand(1,4);

                else if($bedcodeString==82)
                    $randomString .= $bedcode[0].rand(1,3);

                else if($bedcodeString==83)
                    $randomString .= $bedcode[0].rand(1,4);

            else
                $randomString .= $bedcode[rand(1, $bedcodelength - 1)];
        }
        $GLOBALS["linkStr"]=$bedcodeString.$randomString;
        return $bedcodeString.$randomString;
    }

    public function generateRandomDid() {
        $bedcord = $GLOBALS["linkStr"];
        $domitorycode = $bedcord[0].$bedcord[1];
        $floorcode = $bedcord[2];
        $domitorynumber = 0;
        $did = [1,2,3,4];
        
        if($domitorycode=="81")$domitorynumber=$did[0];
        else if($domitorycode=="82"){
            if ($floorcode == "1"){
                $int_value = (int)($bedcord[3].$bedcord[4]);
                if($int_value>11)$domitorynumber=$did[1];
                else $domitorynumber = $did[2];
            }
            else if ($floorcode =="2"){
                $int_value = (int)($bedcord[3].$bedcord[4]);
                if($int_value>14)$domitorynumber=$did[1];
                else $domitorynumber = $did[2];
            }
            else $domitorynumber = $did[1];
        }
        else if($domitorycode=="83")$domitorynumber=$did[3];
        return $domitorynumber;
    }

    public function generateRandomFloor() {
        $bedcord = $GLOBALS["linkStr"];
        $floorcode = $bedcord[2];
        $Floor = [1,2,3,4,5,6,7];
        
        return $Floor=$Floor[array_search($floorcode,$Floor)]."F";
    }

    public function generateRandomRoomtype() {
        $positions = ['三', '四'];
        $bedcord = $GLOBALS["linkStr"];
        $domitorycode = $bedcord[0].$bedcord[1];
        if ($domitorycode == "82")$positions = $positions[0];
        else $positions = $positions[1];
        return $positions . "人房";
    }

    public function run()
    {
        //女一
        for($time=0;$time<6;$time++){
            for($i=1; $i<10; $i++){
                for($j=1;$j<=4;$j++){
                    if($time == 0){
                        $bedcode1 = "8110".$i ."-".$j;
                        $floor = "1F";
                    }
                    elseif($time == 1){
                        $bedcode1 = "8120".$i ."-".$j;
                        $floor = "2F";
                    }
                    elseif($time == 2){
                        $bedcode1 = "8130".$i ."-".$j;
                        $floor = "3F";
                    }
                    elseif($time == 3){
                        $bedcode1 = "8150".$i ."-".$j;
                        $floor = "5F";
                    }
                    elseif($time == 4){
                        $bedcode1 = "8160".$i ."-".$j;
                        $floor = "6F";
                    }
                    else{
                        $bedcode1 = "8170".$i ."-".$j;
                        $floor = "7F";
                    }
                    DB::table('beds')->insert([
                        'bedcode' => $bedcode1,
                        'did' => 1,
                        'floor' => $floor,
                        'roomtype' => "四人房"
                    ]);
                }
            }
        }
        //女二1F
        for($i = 13; $i<29;$i++){
            for($j=1;$j<=3;$j++){
                $bedcode1 = "821".$i ."-".$j;
                DB::table('beds')->insert([
                    'bedcode' => $bedcode1,
                    'did' => 2,
                    'floor' => "1F",
                    'roomtype' => "三人房"
                ]);
            }
        }
        //女二2F
        for($i = 15; $i<33;$i++){
            for($j=1;$j<=3;$j++){
                $bedcode1 = "822".$i ."-".$j;
                DB::table('beds')->insert([
                    'bedcode' => $bedcode1,
                    'did' => 2,
                    'floor' => "2F",
                    'roomtype' => "三人房"
                ]);
            }
        }

        //男一宿MB
        for($i = 1; $i<16;$i++){
            for($j=1;$j<=3;$j++){
                if($i<10)
                    $bedcode1 = "82MB0".$i ."-".$j;
                else
                    $bedcode1 = "82MB".$i ."-".$j;
                DB::table('beds')->insert([
                    'bedcode' => $bedcode1,
                    'did' => 3,
                    'floor' => "0F",
                    'roomtype' => "三人房"
                ]);
            }
        }

        //男一宿1F
        for($i = 4; $i<12;$i++){
            for($j=1;$j<=3;$j++){
                if($i<=10)
                    $bedcode1 = "8210".$i ."-".$j;
                else
                    $bedcode1 = "821".$i ."-".$j;
                DB::table('beds')->insert([
                    'bedcode' => $bedcode1,
                    'did' => 3,
                    'floor' => "1F",
                    'roomtype' => "三人房"
                ]);
            }
        }

        //男一宿2F
        for($i = 1; $i<15;$i++){
            for($j=1;$j<=3;$j++){
                if($i<=10)
                    $bedcode1 = "8220".$i ."-".$j;
                else
                    $bedcode1 = "822".$i ."-".$j;
                DB::table('beds')->insert([
                    'bedcode' => $bedcode1,
                    'did' => 3,
                    'floor' => "2F",
                    'roomtype' => "三人房"
                ]);
            }
        }

        //男一宿3.4.5F
        for($time = 0;$time<3;$time++){
            for($i = 1; $i<33;$i++){
                for($j=1;$j<=3;$j++){
                    if($time == 0){
                        if($i<=10){
                            $bedcode1 = "8230".$i ."-".$j;
                        }
                        else{
                            $bedcode1 = "823".$i ."-".$j;
                        }
                        $floor = "3F";
                        DB::table('beds')->insert([
                            'bedcode' => $bedcode1,
                            'did' => 3,
                            'floor' => $floor,
                            'roomtype' => "三人房"
                        ]);
                    }
                    elseif($time == 1){
                        if($i<=10)
                            $bedcode1 = "8240".$i ."-".$j;
                        else
                            $bedcode1 = "824".$i ."-".$j;
                        $floor = "4F";
                        DB::table('beds')->insert([
                            'bedcode' => $bedcode1,
                            'did' => 3,
                            'floor' => $floor,
                            'roomtype' => "三人房"
                        ]);
                    }
                    else{
                        if($i<=10)
                            $bedcode1 = "8250".$i ."-".$j;
                        else
                            $bedcode1 = "825".$i ."-".$j;
                        $floor = "5F";
                        DB::table('beds')->insert([
                            'bedcode' => $bedcode1,
                            'did' => 3,
                            'floor' => $floor,
                            'roomtype' => "三人房"
                        ]);
                    }
                }
            }
        }
        
        //涵青3、6F
        for($time = 0;$time<2;$time++){
            for($i = 3; $i<40; $i++){
                if($i<10){
                    if($time == 0){
                        if($i == 4 && $i == 6)
                            continue;
                        for($j=1;$j<=4;$j++){
                            $bedcode1 = "8330".$i ."-".$j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "3F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                    else{
                        if($i == 4)
                            continue;
                        for($j=1;$j<=4;$j++){
                            $bedcode1 = "8360".$i ."-".$j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "6F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                }
                else{
                    for($j=1;$j<=4;$j++){
                        if($time == 0){
                            $bedcode1 = "833".$i . "-" . $j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "3F",
                                'roomtype' => "四人房"
                            ]);
                        }
                        else{
                            $bedcode1 = "836".$i . "-" . $j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "6F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                }
            }
        }
        
        //涵青4、5F
        for($time = 0;$time<2;$time++){
            for($i = 0; $i<37; $i++){
                if($i<10){
                    if($i+1 == 2)
                        continue;
                    if($time == 0){
                        for($j=1;$j<=4;$j++){
                            $bedcode1 = "8340".$i+1 ."-".$j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "4F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                    else{
                        for($j=1;$j<=4;$j++){
                            $bedcode1 = "8350".$i+1 ."-".$j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "5F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                }
                else{
                    if($time == 0){
                        for($j=1;$j<=4;$j++){
                            $bedcode1 = "834".$i+1 . "-" . $j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "4F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                    else{
                        for($j=1;$j<=4;$j++){
                            $bedcode1 = "835".$i+1 . "-" . $j;
                            DB::table('beds')->insert([
                                'bedcode' => $bedcode1,
                                'did' => 4,
                                'floor' => "4F",
                                'roomtype' => "四人房"
                            ]);
                        }
                    }
                }
            }
        }
    }
}
