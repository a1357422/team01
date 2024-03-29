<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollcallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rollcalls', function (Blueprint $table) {
            $table->id()->comment("編號");
            $table->string('rollcaller',191)->nullable(true)->comment("點名者");
            $table->date("date")->nullable(false)->comment("點名日期");
            $table->foreignId("sbid")->unsigned()->nullable(false)->comment("學生床位");
            $table->foreign('sbid')->references('id')->on('sbrecords')->onDelete('cascade');
            $table->boolean("presence")->nullable(false)->comment("在場與否")->default(0);
            $table->boolean("leave")->nullable(true)->comment("外宿");
            $table->boolean("late")->nullable(true)->comment("晚歸");
            $table->boolean("identify")->nullable(true)->comment("照片辨識結果");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rollcalls');
    }
}
