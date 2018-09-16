<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class UomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
      $uoms = array("Nos","Mcube","Tons","KGS","BRASS","Ltr","Metre","BOX","BUNDLE");
      foreach($uoms as $uom){
        DB::table('uom')->insert([
            'uom_name' => $uom,
            "uom_status"=>"0"
        ]);
      }
    }
}
