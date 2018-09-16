<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $medias = array("Call","Visit","Friends","Facebook","Google","Newspaper");
      foreach($medias as $media){
        DB::table('media')->insert([
            'media_name' => $media,
            'created_on' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
      }
    }
}
