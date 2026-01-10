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
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('reservation_id');
            $table->double('payment',6,2);
            $table->tinyInteger('payment_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->double('payment_confirm',6,2)->default(0);
            $table->string('user_confirm')->nullable();
            $table->boolean('is_confirm')->default(false);
            $table->unsignedInteger('date')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
