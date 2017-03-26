<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->index()->comment('주문자');
            $table->bigInteger('billable_amount')->nullable()->comment('전체 구매 금액');
            $table->integer('billable_delivery_fee')->default(0)->comment('청구할 배송비');
            $table->string('payment_method')->nullable()->comment('결제 방법');
            $table->timestamp('checkout_at')->nullable()->comment('결제 시각');
            $table->text('message')->nullable()->comment('주문 메시지');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::dropIfExists('orders');
    }
}
