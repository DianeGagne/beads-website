<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        //create the pivot table as well
        Schema::create('beads_finishes', function(Blueprint $table){
            $table->integer('beads_id')->unsigned()->index();
            $table->foreign('beads_id')->references('id')->on('beads')->onDelete('cascade');
            $table->integer('finishes_id')->unsigned()->index();
            $table->foreign('finishes_id')->references('id')->on('finishes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('beads_finishes');
        Schema::drop('finishes');
    }
}
