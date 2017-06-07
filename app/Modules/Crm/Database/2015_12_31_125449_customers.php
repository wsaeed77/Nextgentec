<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customers extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('user_id');
            $table->string('name',50);
            $table->date('created_at');
            $table->date('updated_at');
            $table->date('customer_since');
            $table->string('email_domain',50);
            $table->string('main_phone',15);
            //$table->text('comments');
            //$table->enum('type', ['annual', 'sick']);
            //$table->enum('status', ['pending','approved','rejected']);
           	$table->tinyInteger('is_taxable');
           	$table->tinyInteger('is_active');
           
            
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}
}