<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rate extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('default_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount');
          
            $table->date('created_at');
            $table->date('updated_at');
            
            $table->string('title',20);
           

            
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('default_rates');
	}
}