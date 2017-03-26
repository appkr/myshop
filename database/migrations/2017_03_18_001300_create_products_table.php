<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->index()->comment('상품 등록 직원');
            $table->unsignedInteger('category_id')->index()->comment('연결된 카테고리');
            $table->string('title')->comment('상품명');
            $table->string('sub_title')->nullable()->comment('상품명 보조');
            $table->integer('stock')->default(0)->comment('재고 수량');
            $table->integer('price')->default(0)->comment('상품 가격');
            $table->text('options')->nullable()->comment('상품 옵션');
            $table->text('description')->nullable()->comment('상품 설명');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('products');
    }
}
