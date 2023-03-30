<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment("編號");
            $table->foreignId("sid")->unsigned()->nullable(false)->comment("學生姓名");
            $table->foreign('sid')->references('id')->on('students')->onDelete('cascade');
            $table->string('role')->default(User::ROLE_USER)->comment("權限"); // 加入角色欄位
            $table->string('email')->unique()->comment("電子信箱");
            $table->timestamp('email_verified_at')->nullable()->comment("信箱驗證完成時間");
            $table->string('password')->comment("密碼");
            $table->rememberToken()->comment("令牌");
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
        Schema::dropIfExists('users');
    }
}
