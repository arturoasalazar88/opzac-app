<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->string('name');
            $table->time('horario')->nullable();
            //$table->string('number')->unique();
            $table->string('owner')->default("none"); /// operadora o Maxibus
            $table->integer('cost_kids')->default(0);
            $table->integer('cost_adults')->default(0);
            $table->integer('cost_elders')->default(0);
            $table->string('image')->default('default.jpg');
            $table->integer('limit')->default(0);
            $table->boolean('active')->default(true); /// to check if the tour is active
            $table->text('description');
            $table->boolean('closed')->default(false); /// to close the tour before its limit has benn reached
            $table->date('current'); /// The current date of the current tour, to check if close
            /// Other thing it's to calculate the limit with a SUM() function against the limit field
            /// And just also verify the closed field before any reservation insert.
            $table->timestamps();

            /// Se crea una reserva insert de reservation
            /// En la transacción se revisa primero el id del tour
            /// Se obtiene el Tour->Current('O sólo sería el del día actual')
            /// De las reservaciones se hace el SUM() para saber las reservaciones
            /// que estan para ese día de ese Tour
            /// Esa suma se pone en comparación del límite del tour
            /// Entra o no la nueva reservación dependiendo si se ha cumplido el límite
            /// --- Sí se cumple el límite se cierra CLOSED -> true

            /// Para cerrar el Tour, se hace igualmente lo anterior
            /// Se pone a true el campo CLOSED
            /// El camplo closed únicamente funciona para el tour del día actual
            /// --- Ya no aparece en la lista de tour donde se puede meter reservaciones ese día --
            /// --- O aparece no seleccionable ---

            /// Tendrá que haber una vista para listar los tours con sus horarios y owners
            /// desde ahí poder cerrarlos o abrirlos

            /// Si el límite es alcanzado el tour no se puede abrir ese día, hasta el siguiente.

            /// hay que saber cuando fue ayer y cuando es hoy.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
