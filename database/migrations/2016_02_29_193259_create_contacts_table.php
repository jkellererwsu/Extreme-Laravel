<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->unsigned();
            $table->integer('church_id')->unsigned();
            $table->integer('leader_id')->unsigned()->nullable();
            $table->integer('group_id')->unsigned()->nullable();
			$table->string('fname');
			$table->string('lname');
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->string('email');
            $table->timestamp('bday')->nullable();
            $table->timestamp('anniversary')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('contacts');
    }
}
