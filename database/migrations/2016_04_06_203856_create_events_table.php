<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('displayOrder');
            $table->timestamps();
        });

        DB::table('events')->insert(
            [
                ['id' => 1, 'name' => 'Decision para Cristo - Nuevo', 'displayOrder' => 1],
                ['id' => 2, 'name' => 'Decision para Cristo - Reconciliado', 'displayOrder' => 2],
                ['id' => 3, 'name' => 'Bautismo', 'displayOrder' => 3],
                ['id' => 4, 'name' => 'Recepcion Como Miembro', 'displayOrder' => 4],

            ]
        );

        Schema::create('contact_event', function(Blueprint $table)
        {
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
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
        Schema::drop('contact_event');
        Schema::drop('events');
    }
}
