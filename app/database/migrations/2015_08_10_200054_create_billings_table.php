<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('month_year');
			$table->integer('client');
			$table->string('consumption');
			$table->float('price');
			$table->float('total');
			$table->integer('status');
			$table->integer('user');
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
		Schema::drop('billings');
	}

}
