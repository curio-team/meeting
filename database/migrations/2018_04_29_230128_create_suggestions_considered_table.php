<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestionsConsideredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestions_considered', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suggestion_id')->unsigned();
            $table->integer('schoolyear_id')->unsigned();
            $table->timestamps();

            $table->foreign('suggestion_id')
                    ->references('id')->on('suggestions')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('suggestions_considered');
    }
}
