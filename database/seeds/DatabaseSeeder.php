<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StaffTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(PaymentModeTableSeeder::class);
        $this->call(SiteStatusTableSeeder::class);
        //$this->call(SiteImageTableSeeder::class);
    }
}
