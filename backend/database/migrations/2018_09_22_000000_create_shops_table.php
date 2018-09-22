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
            $table->string('county');
            $table->string('address');
            $table->string('telefon');
            $table->string('email');
            $table->string('luni')->nullable();
            $table->string('marti')->nullable();
            $table->string('miercuri')->nullable();
            $table->string('joi')->nullable();
            $table->string('vineri')->nullable();
            $table->string('sambata')->nullable();
            $table->string('duminica')->nullable();
            $table->double('latitudine', 7, 5);
            $table->double('longitudine', 7, 5);
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
