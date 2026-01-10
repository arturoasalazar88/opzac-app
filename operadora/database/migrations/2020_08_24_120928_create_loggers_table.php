<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loggers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');
            $table->string('controller');
            $table->string('function');
            $table->string('action');
            $table->text('parameter');
            $table->string('user');
            $table->string('rol')->nullable();
            $table->string('company');
            $table->string('tour')->nullable();
            $table->string('day')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('loggers');
    }
}
