<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        $user = new User();
        $user->username='saloodo';
        $user->email='saloodo@mail.com';
        $user->first_name='Sahid';
        $user->last_name='Hossen';
        $user->password=Hash::make('saloodo111');
        $user->save();

        $rootRole = Role::where('name','=','admin')->first();
        $user->attachRole($rootRole);

         // Create customer
         $user = new User();
         $user->username='customer1';
         $user->email='customer1@mail.com';
         $user->first_name='Gracie';
         $user->last_name='Weber';
         $user->password=Hash::make('customer111');
         $user->save();
 
         $rootRole = Role::where('name','=','customer')->first();
         $user->attachRole($rootRole);

        // Create customer
         $user = new User();
         $user->username='customer2';
         $user->email='customer2@mail.com';
         $user->first_name='Roscoe';
         $user->last_name='Johns';
         $user->password=Hash::make('customer111');
         $user->save();

         $rootRole = Role::where('name','=','customer')->first();
         $user->attachRole($rootRole);

         // Create customer
         $user = new User();
         $user->username='customer3';
         $user->email='customer3@mail.com';
         $user->first_name='Emmett';
         $user->last_name='Lebsack';
         $user->password=Hash::make('customer111');
         $user->save();

         $rootRole = Role::where('name','=','customer')->first();
         $user->attachRole($rootRole);
    }
}
