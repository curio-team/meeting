<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->string('slug');
            $table->string('owner');
            $table->string('title');
            $table->boolean('urgent')->nullable();
            $table->timestamp('resonated_at')->nullable();
            $table->timestamp('secured_at')->nullable();
            $table->timestamp('filed_at')->nullable();
            $table->timestamps();

            $table->foreign('topic_id')
                    ->references('id')->on('topics');

            // $table->foreign('owner')
            //         ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
