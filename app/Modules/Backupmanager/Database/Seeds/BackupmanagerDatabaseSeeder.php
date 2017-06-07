<?php
namespace App\Modules\Backupmanager\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BackupmanagerDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('App\ModulesBackupmanager\Database\Seeds\FoobarTableSeeder');
	}

}
