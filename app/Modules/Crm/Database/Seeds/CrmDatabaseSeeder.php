<?php
namespace App\Modules\Crm\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CrmDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('App\ModulesCrm\Database\Seeds\FoobarTableSeeder');
	}

}
