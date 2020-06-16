<?php

use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$lines = DB::table('lines')->get();
        $countLines = count($lines);
        for ($i = 1; $i <= $countLines; $i++) {
        	for ($s = 1; $s <= 3; $s++) {
        		if ($s === 1) {
        			$data = [
        				'line_id' => '',
        				'name' => 'Рання зміна',
        				'time_begin' => 0, 
        				'time_end' => 8
        			];
        		} elseif ($s === 2) {
        			$data = [
        				'line_id' => '',
        				'name' => 'Денна зміна',
        				'time_begin' => 8, 
        				'time_end' => 16
        			];
        		} else {
        			$data = [
        				'line_id' => '',
        				'name' => 'Нічна зміна',
        				'time_begin' => 16, 
        				'time_end' => 24
        			];
        		}
        		$data['line_id'] = $lines[$i - 1]->id;
        		DB::table('shifts')->insert($data);
        	}
        }
    }
}
