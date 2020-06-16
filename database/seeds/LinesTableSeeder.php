<?php

use Illuminate\Database\Seeder;

class LinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$countLines = 5;
    	for ($i = 1; $i <= $countLines; $i++) {
    		DB::table('lines')->insert([
            	'number' => $i,
            	'name' => 'Лінія ' . $i 
        	]);
		}
    }
}
