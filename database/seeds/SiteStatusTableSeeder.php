<?php

use Illuminate\Database\Seeder;
class SiteStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
      $site_status = array("Completed","Ongoing","Future");
      foreach($site_status as $site_status){
        DB::table('site_status')->insert([
            'site_status_name' => $site_status
        ]);
      }
    }
}