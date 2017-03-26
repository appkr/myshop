<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->index()->comment('리뷰어');
            $table->unsignedInteger('order_id')->index()->comment('주문 번호');
            $table->text('content')->nullable()->comment('리뷰 본문');
            $table->tinyInteger('rating')->nullable()->comment('평점');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['order_id']);
        });

        Schema::dropIfExists('reviews');
    }
}
