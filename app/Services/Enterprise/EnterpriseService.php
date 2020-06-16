<?php

namespace App\Services\Enterprise;

use App\Services\AbstractService;
use App\Repositories\Shift\ShiftRepository;
use App\Repositories\EnterpriseDay\EnterpriseDayRepository;
use App\Repositories\Sensor\SensorRepository;
use App\Repositories\Control\ControlRepository;

class EnterpriseService extends AbstractService implements EnterpriseInterface
{
    protected $shiftRepository;

    protected $enterpriseDayRepository;

    protected $sensorRepository;

    protected $controlRepository;

    public function __construct(ShiftRepository $shiftRepository, EnterpriseDayRepository $enterpriseDayRepository, SensorRepository $sensorRepository, ControlRepository $controlRepository)
    {
        $this->shiftRepository = $shiftRepository;
        $this->enterpriseDayRepository = $enterpriseDayRepository;
        $this->sensorRepository = $sensorRepository;
        $this->controlRepository = $controlRepository;
    }

    public function generateEnterpriseDay()
    {
        $shifts = $this->shiftRepository->getAllNoLimit();
        $shiftsCount = count($shifts);
        $dayShiftCount = 3;
        $enterpriseDays = $this->enterpriseDayRepository->getAll();
        $enterpriseDaysCount = count($enterpriseDays);
        $enterpiseDayNumber = count($enterpriseDays) === 0 ? 
            1 :
            $enterpriseDays[$enterpriseDaysCount - 1]->number + 1;
        $day = $this->enterpriseDayRepository->create([
            'number' => $enterpiseDayNumber
        ]);

        for ($s = 1; $s <= $dayShiftCount; $s++) { 
            for ($i = 0; $i < $shiftsCount; $i++) { 
                if ($s === 1 && $shifts[$i]->name === 'Рання зміна') {
                    $this->generateShiftSensorData($shifts[$i]->id, $day->id);
                    $this->generateShiftControlData($shifts[$i]->id, $day->id);
                }

                if ($s === 2 && $shifts[$i]->name === 'Денна зміна') {
                    $this->generateShiftSensorData($shifts[$i]->id, $day->id);
                    $this->generateShiftControlData($shifts[$i]->id, $day->id);    
                }

                if ($s === 3 && $shifts[$i]->name === 'Нічна зміна') {
                    $this->generateShiftSensorData($shifts[$i]->id, $day->id);
                    $this->generateShiftControlData($shifts[$i]->id, $day->id);
                }
            }
        }
        
    }

    public function generateShiftSensorData($shiftId, $enterpiseDayId)
    {
        $shiftDataRowsCount = 48;

        for ($i = 0; $i < $shiftDataRowsCount; $i++) {

            $humidity = mt_rand(544760371, 894298609)/1000000000;
            $temperature = mt_rand(1342525843, 1365323847)/10000000;
            $drum_speed = mt_rand(2, 3);
            $processed_carbon = mt_rand(480, 660);
            $first_zone_fuel = mt_rand(96, 186);
            $second_zone_fuel = mt_rand(162, 174);
            $third_zone_gas = mt_rand(167, 217)/100;
            $burner_gas = mt_rand(183, 233)/100;
            $drum_drive_energy = mt_rand(4, 5);
            $first_compressor_energy = mt_rand(10, 13)/10;
            $second_compressor_energy = mt_rand(23, 30)/10;
            $third_compressor_energy = mt_rand(23, 30)/10;
            $additional_functions_energy = mt_rand(9, 11);
            $water_solution = mt_rand(678, 750);

            $data = [
                'enterprise_day_id' => $enterpiseDayId,
                'shift_id' => $shiftId,
                'humidity' => $humidity,
                'temperature' => $temperature,
                'drum_speed' => $drum_speed,
                'processed_carbon' => $processed_carbon,
                'first_zone_fuel' => $first_zone_fuel,
                'second_zone_fuel' => $second_zone_fuel,
                'third_zone_gas' => $third_zone_gas,
                'burner_gas' => $burner_gas,
                'drum_drive_energy' => $drum_drive_energy,
                'first_compressor_energy' => $first_compressor_energy,
                'second_compressor_energy' => $second_compressor_energy,
                'third_compressor_energy' => $third_compressor_energy,
                'additional_functions_energy' => $additional_functions_energy,
                'water_solution' => $water_solution
            ];

            $this->sensorRepository->create($data);
        }    
    }

    public function generateShiftControlData($shiftId, $enterpiseDayId)
    {
        $shiftDataRowsCount = 4;
        $carbonBlackMarks = ['N110', 'N220', 'S315', 'N330', 'N550', 'N683', 'N772', 'N990'];
        $carbonBlackMark = $carbonBlackMarks[array_rand($carbonBlackMarks, 1)];

        for ($i = 0; $i < $shiftDataRowsCount; $i++) {   
            $humidity = mt_rand(2, 9)/10;
            $granule_size = mt_rand(2, 10);
            $abrasion_resistance = mt_rand(87, 95);
            $drum_outlet_temperature = mt_rand(120, 195);

            if ($carbonBlackMark === 'N110') {
                $specific_surface_area = mt_rand(126, 128);
                $iodine_number = mt_rand(144, 146);
                $oil_absorption = mt_rand(112, 114);
                $bulk_density = mt_rand(342, 348);
            }

            if ($carbonBlackMark === 'N220') {
                $specific_surface_area = mt_rand(113, 115);
                $iodine_number = mt_rand(120, 122);
                $oil_absorption = mt_rand(113, 115);
                $bulk_density = mt_rand(351, 359);
            }

            if ($carbonBlackMark === 'S315') {
                $specific_surface_area = mt_rand(88, 90);
                $iodine_number = 0;
                $oil_absorption = mt_rand(78, 80);
                $bulk_density = mt_rand(421, 429);
            }

            if ($carbonBlackMark === 'N330') {
                $specific_surface_area = mt_rand(77, 79);
                $iodine_number = mt_rand(81, 83);
                $oil_absorption = mt_rand(101, 103);
                $bulk_density = mt_rand(376, 384);
            }

            if ($carbonBlackMark === 'N550') {
                $specific_surface_area = mt_rand(39, 40);
                $iodine_number = mt_rand(42, 43);
                $oil_absorption = mt_rand(120, 122);
                $bulk_density = mt_rand(356, 364);
            }

            if ($carbonBlackMark === 'N683') {
                $specific_surface_area = mt_rand(35, 36);
                $iodine_number = mt_rand(34, 35);
                $oil_absorption = mt_rand(132, 134);
                $bulk_density = mt_rand(351, 359);
            }

            if ($carbonBlackMark === 'N772') {
                $specific_surface_area = mt_rand(31, 32);
                $iodine_number = mt_rand(29, 30);
                $oil_absorption = mt_rand(64, 66);
                $bulk_density = mt_rand(515, 525);
            }

            if ($carbonBlackMark === 'N990') {
                $specific_surface_area = mt_rand(7, 8);
                $iodine_number = 0;
                $oil_absorption = mt_rand(42, 43);
                $bulk_density = mt_rand(634, 646);
            }

            $data = [
                'enterprise_day_id' => $enterpiseDayId,
                'shift_id' => $shiftId,
                'mark' => $carbonBlackMark,
                'humidity' => $humidity,
                'specific_surface_area' => $specific_surface_area,
                'iodine_number' => $iodine_number,
                'oil_absorption' => $oil_absorption,
                'bulk_density' => $bulk_density,
                'granule_size' => $granule_size,
                'abrasion_resistance' => $abrasion_resistance,
                'drum_outlet_temperature' => $drum_outlet_temperature
            ];

            $this->controlRepository->create($data);
        }    
    }
}