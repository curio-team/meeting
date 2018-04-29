<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_id')->unsigned();
            $table->integer('topic_id')->unsigned();
            $table->integer('added_by')->unsigned();
            $table->integer('duration')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('meeting_id')
                    ->references('id')->on('meetings')
                    ->onDelete('cascade');

            $table->foreign('topic_id')
                    ->references('id')->on('topics')
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
        Schema::dropIfExists('agenda_items');
    }
}
