<?php
namespace App\Modules\Vendor\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class VendorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('App\ModulesVendor\Database\Seeds\FoobarTableSeeder');
    }
}
