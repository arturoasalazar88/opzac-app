<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('hotel_id')->default(1);
            $table->string('name');
            $table->string('username')->unique();
            $table->unsignedInteger('role_id');
            $table->boolean('is_admin')->default(false);
            $table->decimal('comission_kids', 4, 2)->default(0.0);
            $table->decimal('comission_adults', 4, 2)->default(0.0);
            $table->decimal('comission_elders', 4, 2)->default(0.0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
