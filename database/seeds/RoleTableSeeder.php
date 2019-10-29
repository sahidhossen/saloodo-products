<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Super admin'; // optional
        $admin->description  = 'Admin who will be handle product details'; // optional
        $admin->save();

        $delivery = new Role();
        $delivery->name         = 'customer';
        $delivery->display_name = 'Customers'; // optional
        $delivery->description  = 'Customers will order the products'; // optional
        $delivery->save();
    }
}
