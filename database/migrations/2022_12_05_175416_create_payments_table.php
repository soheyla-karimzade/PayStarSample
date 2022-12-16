<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('order_id');
            $table->string('ref_num');
            $table->string('transaction_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('token');
            $table->integer('status');
            $table->string('message');
            $table->string('tracking_code')->nullable();
            $table->json('data');
            $table->decimal('amount');
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');


//            $table->foreignIdFor(\App\Model\Product::class);
//            $table->foreignIdFor(\App\User::class);

            $table->timestamps();
        });


//        Schema::table('payments', function (Blueprint $table) {
//            $table->foreign('product')->references('id')->on('products');
//            $table->foreign('user')->references('id')->on('users');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
