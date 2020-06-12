<?php

use Illuminate\Database\Seeder;

class LotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $lots_title = ['Яблоки', 'Дом', 'Автомобиль', 'Телевизор', 'Диван', 'Авто', 'Кот', 'Лот 8', 'Лот 9', 'Лот 10', 'Лот 11', 'Лот 12', 'Лот 14', 'Лот 15'];
        $lots_description = ['Яблоки зеленые, урожай 2020', 'Дом, 3 спальни, 140 кв.м', 'Авто Поло седан 2018 года выпуска, пробег 37000 км.', 'Телевизор самсунг, диагональ 50 дюймов', 'Диван мягкий кожа', 'Авто, быстрый', 'Кот пушистый', 'Описание  для Лот 8', 'Описание  для Лот 9', 'Описание  для Лот 10', 'Описание  для Лот 11', 'Описание  для Лот 12', 'Описание  для Лот 14', 'Описание  для Лот 15'];

        for($i=0; $i<14; $i++)
        {
        	$rate = rand(5000, 5500);
        	DB::table('lots')->insert([
		        'title' => $lots_title[$i],
        		'description' => $lots_description[$i],
        		'owner_id' => rand(1,5),
        		'created_at' => now()->addMinutes(-$i),
        		'starting_rate' => $rate,
        		'current_rate' => $rate,
        		'completion_time' => now()->addMinutes(10080+$i*150),
        		'lot_completed' => 0,
        		'current_buyer' => 0,

        	]);
    	}
    }

}
