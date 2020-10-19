<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('np_department_id');
            $table->string('stripe_order_id');
            $table->unsignedDecimal('amount');

            $table->unsignedInteger('status_id')->default(1);
            $table->text('info');

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('np_department_id')->references('id')->on('np_departments');

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
        Schema::dropIfExists('orders');
    }
}
