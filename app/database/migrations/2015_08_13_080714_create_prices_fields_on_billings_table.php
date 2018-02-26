<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesFieldsOnBillingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('billings', function(Blueprint $table)
		{
			$table->integer('unit_normal');
			$table->float('price_normal');
			$table->integer('unit_excess');
			$table->float('price_excess');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('billings', function(Blueprint $table)
		{
			$table->dropColumn('unit_normal');
			$table->dropColumn('price_normal');
			$table->dropColumn('unit_excess');
			$table->dropColumn('price_excess');
		});
	}

}
