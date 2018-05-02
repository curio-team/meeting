<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schoolyear_id')->unsigned();
            $table->integer('year');
            $table->integer('iso_week');
            $table->integer('term')->nullable();
            $table->integer('week')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('schoolyear_id')
                    ->references('id')->on('schoolyears')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weeks');
    }
}
