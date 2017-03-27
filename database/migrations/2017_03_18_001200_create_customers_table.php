<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('사용자 이름');
            $table->string('email')->unique()->comment('이메일 (로그인에 사용됨)');
            $table->string('password')->nullable()->comment('비밀번호');
            $table->rememberToken()->comment('로그인 기억 토큰');
            $table->string('zipcode', 10)->nullable()->comment('우편번호');
            $table->string('address')->nullable()->comment('주소');
            $table->string('phone_number', 20)->nullable()->comment('전화번호');
            $table->date('date_of_birth')->nullable()->comment('생년월일');
            $table->string('gender', 10)->nullable()->comment('성별');
            $table->text('profile')->nullable()->comment('자기 소개');
            $table->integer('points')->default(0)->comment('포인트');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
