<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->date('created_at');
            $table->date('updated_at');
            
            $table->string('location_name', 150);
            $table->string('address', 400);
            $table->string('country', 30);
            $table->string('city', 30);
            $table->string('state', 30);
            $table->integer('zip');
            $table->string('phone', 15);
           
            
            $table->tinyInteger('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customer_locations');
    }
}
