<?php
namespace App\Modules\Employee\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EmployeeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('App\ModulesEmployee\Database\Seeds\FoobarTableSeeder');
    }
}
