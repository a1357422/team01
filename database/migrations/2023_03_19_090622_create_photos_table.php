<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->date("date")->nullable(false)->comment("日期");
            $table->foreignId("sbid")->unsigned()->nullable(false)->comment("學生編號");
            $table->foreign('sbid')->references('id')->on('sbrecords')->onDelete('cascade');
            $table->string('roomphoto_file_path',191)->nullable(true)->comment("房間照片上傳路徑");
            $table->string('upload_file_path',191)->nullable(true)->comment("上傳照片路徑");
            $table->string('webcam_file_path',191)->nullable(true)->comment("拍攝照片路徑");
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
        Schema::dropIfExists('photos');
    }
}
