<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('contact_position', function(Blueprint $table)
        {
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->integer('position_id')->unsigned()->index();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');

            $table->timestamps();
        });

        // Insert some stuff
        DB::table('positions')->insert(
            [
                ['id' => 1, 'title' => 'Líder de 12'],
                ['id' => 2, 'title' => 'Líder de casa de oración'],
                ['id' => 3, 'title' => 'Timoteo'],
                ['id' => 4, 'title' => 'Anfitrión'],
                ['id' => 5, 'title' => 'Miembro'],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contact_position');
        Schema::drop('positions');
    }
}
