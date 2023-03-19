<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebcamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webcams', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sbid")->unsigned()->nullable(false)->comment("學生姓名");
            $table->foreign('sbid')->references('id')->on('sbrecords')->onDelete('cascade');
            $table->string('file_path',191)->nullable(true)->comment("照片路徑");
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
        Schema::dropIfExists('webcams');
    }
}
