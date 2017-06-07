<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contacts extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_location_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_location_id');
            $table->date('created_at');
            $table->date('updated_at');
            $table->string('f_name',15);
            $table->string('l_name',15);
            $table->string('title',20);
            $table->string('email',30);
            $table->string('phone',15);
            $table->string('mobile',15);
            

           $table->tinyInteger('is_poc');
           
           
            
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_location_contacts');
	}
}