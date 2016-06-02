<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('church_id')->unsigned();
            $table->integer('leader_id')->unsigned()->nullable();
            $table->integer('host_id')->unsigned()->nullable();
            $table->integer('timothy_id')->unsigned()->nullable();
            $table->integer('status')->unsigned();
            $table->string('name');
            $table->string('day');
            $table->string('time');
            $table->string('city');
            $table->string('address');
            $table->timestamp('founded');
            $table->timestamps();

            $table->foreign('church_id')
                ->references('id')
                ->on('churches');
            $table->foreign('leader_id')
                ->references('id')
                ->on('contacts');
            $table->foreign('host_id')
                ->references('id')
                ->on('contacts');
            $table->foreign('timothy_id')
                ->references('id')
                ->on('contacts');
        });

        Schema::create('contact_group', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::drop('contact_group');
        Schema::drop('groups');
    }
}
