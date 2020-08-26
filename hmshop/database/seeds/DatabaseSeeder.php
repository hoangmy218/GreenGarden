<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // DB::table('categories')->insert([
        //     ['cate_name'=>'cactus','cate_des'=>'plant that grows in the desert'],
        //     ['cate_name'=>'rose','cate_des'=>'rose flower'],
        // ]);

        DB::table('payments')->insert([
            ['pm_name'=>'Stripe'],
            ['pm_name'=>'shipcode'],
        ]);

        DB::table('roles')->insert([
            ['role_name'=>'admin'],
            ['role_name'=>'customer'],
        ]);

        DB::table('order_states')->insert([
            ['st_name'=>'init'],
            ['st_name'=>'confirmed'],
            ['st_name'=>'processing'],
            ['st_name'=>'completed'],
        ]);
        DB::table('users')->insert([
            ['id'=>'1', 'name'=>'HoangMy', 'email'=>'superadmin@gmail.com', 'password'=>bcrypt('admin'),'role_id'=>'1'],
        ]);

    }
}
