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
            $table->string('order_code',255);
            $table->string('order_name',255);
            $table->string('email',255);
            $table->string('phone',255);
            $table->text('notes');
            $table->string('order_status',255);
            $table->string('payment',255);
            $table->string('province',255);
            $table->string('district',255);
            $table->string('wards',255);
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
