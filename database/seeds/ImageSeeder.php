<?php

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $name_img = ['10.jpeg', '20.jpg', '21.png', '22.jpeg', '30.jpg', '31.jpg', '50.jpg', '70.jpg', '9.jpg', '5.jpg'];
        $lot_id = [1, 2, 2, 2, 3, 3, 4,5,6,7];

        for($i=0; $i<10; $i++)
        {
        	DB::table('images')->insert([
        		'img' => '/storage/'.$name_img[$i],
        		'lot_id' => $lot_id[$i],
        	]);
    	}
    }

}
