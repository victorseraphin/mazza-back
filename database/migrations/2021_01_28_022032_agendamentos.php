<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Agendamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->increments('id'); 
            $table->unsignedInteger('medicos_id')->nullable();
            $table->foreign('medicos_id')->references('id')->on('medicos')->onDelete('cascade');  

            $table->unsignedInteger('pacientes_id')->nullable();
            $table->foreign('pacientes_id')->references('id')->on('pacientes')->onDelete('cascade');  

            $table->date('data');
            $table->string('hora_ini',5);
            $table->string('hora_fin',5);
            $table->string('status',1)->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
