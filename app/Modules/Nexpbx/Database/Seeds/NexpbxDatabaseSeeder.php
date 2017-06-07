<?php
namespace App\Modules\Nexpbx\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NexpbxDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('App\ModulesNexpbx\Database\Seeds\FoobarTableSeeder');
	}

}
