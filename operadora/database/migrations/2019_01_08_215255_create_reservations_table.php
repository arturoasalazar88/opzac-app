<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(0);
            $table->boolean('confirmed')->default(false);
            $table->string('client');
            $table->string('client_email')->nullable();
            $table->string('telephone');
            /// Not yet implemented
            $table->string('procedence')->nullable(); /// The procendence of the client
            $table->integer('room')->nullable();
            $table->date('date');
            $table->integer('number_kids')->default(0);
            $table->integer('number_adults')->default(0);
            $table->integer('number_elders')->default(0);
            $table->decimal('comission_kids',6,2)->default(0);
            $table->decimal('comission_adults',6,2)->default(0);
            $table->decimal('comission_elders',6,2)->default(0);
            $table->decimal('total_kids',6,2)->default(0);
            $table->decimal('total_adults',6,2)->default(0);
            $table->decimal('total_elders',6,2)->default(0);
            $table->decimal('price_kids',6,2)->default(0);
            $table->decimal('price_adults',6,2)->default(0);
            $table->decimal('price_elders',6,2)->default(0);
            /// TOTAL OF THE RESERVATION
            $table->decimal('total',6,2);
            $table->decimal('first_payment',6,2)->default(0);
            /// TOTAL OF THE COMISION
            /// STILL THE NEED TO KNOW THE COMMISSION TOTAL
            $table->decimal('total_commission',6,2);
            $table->decimal('remaining',6,2); /// THE REST OF THE TOTAL MINUS THE COMMISSION
            $table->decimal('actual_pay',6,2); /// THE CURRENT PAID AMOUNT
            $table->string('payment_method');
            $table->string('credit_numbers')->default('XXXX');
            $table->string('citypass')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tour_id')->nullable();
            $table->unsignedInteger('departure_id');
            $table->unsignedInteger('hotel_id');
            $table->string('folio');
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
