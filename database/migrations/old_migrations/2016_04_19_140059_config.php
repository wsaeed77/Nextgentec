<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Config extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 250);
            $table->string('key', 250);
            $table->text('value');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
         });
    }

    
    public function down()
    {

        Schema::drop('config');
    }
}
