<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 15);
            //$table->foreign('user_id')->references('id')->on('users');
            $table->integer('approved_by');
            //$table->foreign('approved_by')->references('id')->on('users');
            $table->date('created_at');
            $table->date('updated_at');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('comments');
            $table->enum('type', ['annual', 'sick']);
            $table->enum('status', ['pending','approved','rejected']);
            $table->tinyInteger('google_post');
            $table->string('google_id', 50);
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('leaves');
    }
}
