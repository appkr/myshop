<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeProductIdNullableOnImagesTable extends Migration
{
    public function up()
    {
//        Schema::table('images', function (Blueprint $table) {
//            $table->unsignedInteger('product_id')->nullable()->change();
//        });
    }

    public function down()
    {
//        Schema::table('images', function (Blueprint $table) {
//            $table->unsignedInteger('product_id')->nullable(false)->change();
//        });
    }
}
