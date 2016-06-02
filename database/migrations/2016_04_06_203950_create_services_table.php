<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('church_id')->unsigned();
            $table->string('name');
            $table->integer('type');
            $table->integer('displayOrder');
            $table->timestamps();

            $table->foreign('church_id')
                ->references('id')
                ->on('churches');
        });

        Schema::create('attendances', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('service_id')->unsigned()->index();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->integer('adults')->unsigned()->nullable();
            $table->integer('kids')->unsigned()->nullable();
            $table->integer('extremies')->unsigned()->nullable();
            $table->integer('offering')->unsigned()->nullable();
            $table->integer('tithe')->unsigned()->nullable();
            $table->integer('other_income')->unsigned()->nullable();
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
        Schema::drop('attendances');
        Schema::drop('services');
    }
}
