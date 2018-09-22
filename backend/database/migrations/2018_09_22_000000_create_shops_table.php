<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');

            $table->string('dealer_name');
            $table->string('city');
            $table->string('country');
            $table->string('address');
            $table->string('telefon');
            $table->string('email');
            $table->string('luni');
            $table->string('marti');
            $table->string('miercuri');
            $table->string('joi');
            $table->string('vineri');
            $table->string('sambata');
            $table->string('duminica');
            $table->double('latitude', 7, 5);
            $table->double('longitude', 7, 5);
            $table->string('profil_magazin');
            $table->integer('cod_postal');


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
        Schema::dropIfExists('shops');
    }
}
