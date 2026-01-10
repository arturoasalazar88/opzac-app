<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('departure_id');
            $table->date('date');
            $table->integer('seat');
            $table->unsignedInteger('reservation_id');
            $table->integer('type')->default(0);
            $table->timestamps();

            $table->unique(['departure_id', 'date', 'seat']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
