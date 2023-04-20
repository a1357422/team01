<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SbrecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1;$i<1253;$i++){
            DB::table('sbrecords')->insert([
                'school_year' => 111,
                'semester' => 2,
                'sid' => $i,
                'bid' => $i
                ]);
        }
        
    }
}
