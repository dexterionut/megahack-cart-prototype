<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');

            $table->string('display_name');
            $table->string('nume_produs');
            $table->string('name');
            $table->string('producator');
            $table->string('caracteristici_principale');
            $table->string('diagonala_ecran')->nullable();
            $table->string('camera')->nullable();;
            $table->string('memorie_interna');

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
        Schema::dropIfExists('phones');
    }
}
