<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->index()->comment('주문');
            $table->unsignedInteger('address_id')->index()->comment('배송 목적지');
            $table->float('weight')->default(0.00)->comment('무게');
            $table->string('package_type')->default('PAPER_BOX')->default('포장재');
            $table->string('status', 20)->default('SUBMITTED')->comment('배송상태');
            $table->string('agent', 20)->default('EMS')->comment('택배사');
            $table->integer('payable_delivery_fee')->default(0)->comment('정산할 배송비');
            $table->text('message')->nullable()->comment('배송 메시지');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['address_id']);
        });

        Schema::dropIfExists('deliveries');
    }
}
