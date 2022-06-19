<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->truncate();
        DB::table('users')->insert(array(            
            array(
                "name" => "PhyoNaing Htun",  
                "email" => "phyonainghtun.itwork@gmail.com",  
                "email_verified_at" => Carbon::now()->format('Y-m-d H:m:s'),                                      
                "password" => Hash::make('12345'),
                "created_at" => Carbon::now()->format('Y-m-d H:m:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:m:s')
            ),
            array(
                "name" => "Admin",  
                "email" => "admin@gmail.com",  
                "email_verified_at" => Carbon::now()->format('Y-m-d H:m:s'),                                      
                "password" => Hash::make('12345'),
                "created_at" => Carbon::now()->format('Y-m-d H:m:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:m:s')
            )
        ));
    }
}
