<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('church_id')->unsigned();
            $table->integer('displayOrder');
            $table->string('name');
            $table->string('short_name');
            $table->string('category');
            $table->integer('payment')->unsigned();
            $table->timestamps();

            $table->foreign('church_id')
                ->references('id')
                ->on('churches');
        });

        Schema::create('contact_training', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->integer('training_id')->unsigned()->index();
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');
            $table->integer('paid')->unsigned()->nullable();
            $table->string('note');
            $table->timestamp('date');

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
        Schema::drop('contact_training');
        Schema::drop('trainings');
    }
}
