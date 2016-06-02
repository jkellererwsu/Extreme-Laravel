<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToUsersContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('church_id')
                ->references('id')
                ->on('churches')
                ->onDelete('cascade');
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts');

        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('church_id')
                ->references('id')
                ->on('churches')
                ->onDelete('cascade');
            $table->foreign('leader_id')
                ->references('id')
                ->on('contacts');
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropForeign(['contact_id']);

        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropForeign(['leader_id']);
            $table->dropForeign(['group_id']);

        });
    }
}
