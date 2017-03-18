<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('questionable');
            $table->unsignedInteger('product_id')->index()->comment('상품 ID');
            $table->unsignedInteger('parent_id')->nullable()->index()->comment('질문 쓰레드 부모');
            $table->string('type', 10)->default('QUESTION')->index();
            $table->text('content')->nullable()->comment('질문 또는 답변 본문');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('parent_id')->references('id')->on('questions');
            $table->index(['questionable_type', 'questionable_id'], 'questions_questionable_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('questions');
    }
}
