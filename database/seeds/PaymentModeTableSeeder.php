<?php

use Illuminate\Database\Seeder;

class PaymentModeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $medias = array("Cash","Cheque","Online");
      foreach($medias as $media){
        DB::table('payment_mode')->insert([
            'payment_mode_name' => $media
        ]);
      }
    }
}
