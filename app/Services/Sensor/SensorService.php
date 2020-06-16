<?php

namespace App\Services\Sensor;

use App\Repositories\Sensor\SensorRepository;
use App\Repositories\Line\LineRepository;
use App\Services\AbstractService;

class SensorService extends AbstractService implements SensorInterface
{
    protected $lineRepository;

    /**
     * Initialize class properties
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(SensorRepository $sensorRepository, LineRepository $lineRepository)
    {
        $this->repository = $sensorRepository;
        $this->lineRepository = $lineRepository;
        $this->paginationRowsCount = 10;
    }

    public function getEnergyPerShift($shiftId, $enterpriseDay)
    {
        $shiftData = $this->repository->getShiftData($shiftId, $enterpriseDay);
        $dataRowsCount = count($shiftData);
        $drumDriveEnergyPerShift = 0;
        $firstCompressorEnergyPerShift = 0;
        $secondCompressorEnergyPerShift = 0;
        $thirdCompressorEnergyPerShift = 0;
        $additionalFunctionsEnergyPerShift = 0;

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $drumDriveEnergyPerShift += $shiftData[$i]->drum_drive_energy;
            $firstCompressorEnergyPerShift += $shiftData[$i]->first_compressor_energy;
            $secondCompressorEnergyPerShift += $shiftData[$i]->second_compressor_energy;
            $thirdCompressorEnergyPerShift += $shiftData[$i]->third_compressor_energy;
            $additionalFunctionsEnergyPerShift += $shiftData[$i]->additional_functions_energy;
        }

        $energyPerShift = $drumDriveEnergyPerShift +
            $firstCompressorEnergyPerShift +
            $secondCompressorEnergyPerShift +
            $thirdCompressorEnergyPerShift +
            $additionalFunctionsEnergyPerShift; 

        $statistics = [
            'drumDriveEnergyPerShift' => $drumDriveEnergyPerShift,
            'firstCompressorEnergyPerShift' => $firstCompressorEnergyPerShift,
            'secondCompressorEnergyPerShift' => $secondCompressorEnergyPerShift,
            'thirdCompressorEnergyPerShift' => $thirdCompressorEnergyPerShift,
            'additionalFunctionsEnergyPerShift' => $additionalFunctionsEnergyPerShift,
            'energyPerShift' => $energyPerShift
        ];

        return $statistics;
    }

    public function getUnitCostsPerShift($shiftId, $enterpriseDay)
    {
        $shiftData = $this->repository->getShiftData($shiftId, $enterpriseDay);
        $dataRowsCount = count($shiftData);
        $statistics = [];
        $data = [
            'measurementNumbers' => [],
            'measurements' => [],
            'energy' => [
                'drumDriveEnergy' => 0,
                'firstCompressorEnergy' => 0,
                'secondCompressorEnergy' => 0,
                'thirdCompressorEnergy' => 0,
                'additionalFunctionsEnergy' => 0,
                'allEnergy' => 0
            ],
            'fuel' => [
                'firstZoneFuel' => 0,
                'secondZoneFuel' => 0,
                'allFuel' => 0
            ],
            'gas' => [
                'thirdZoneGas' => 0,
                'burnerGas' => 0,
                'allGas' => 0
            ],
            'processedCarbon' => 0
        ];


        for ($i = 0; $i < $dataRowsCount; $i++) {
            $data['processedCarbon'] += $shiftData[$i]->processed_carbon;
            array_push($data['measurementNumbers'], $i + 1); 
            array_push($data['measurements'], $shiftData[$i]); 
            $data['energy']['drumDriveEnergy'] += $shiftData[$i]->drum_drive_energy;
            $data['energy']['firstCompressorEnergy'] += $shiftData[$i]->first_compressor_energy;
            $data['energy']['secondCompressorEnergy'] += $shiftData[$i]->second_compressor_energy;
            $data['energy']['thirdCompressorEnergy'] += $shiftData[$i]->third_compressor_energy;
            $data['energy']['additionalFunctionsEnergy'] += $shiftData[$i]->additional_functions_energy;
            $data['energy']['allEnergy'] += ($shiftData[$i]->drum_drive_energy +
                $shiftData[$i]->first_compressor_energy +
                $shiftData[$i]->second_compressor_energy +
                $shiftData[$i]->third_compressor_energy +
                $shiftData[$i]->additional_functions_energy);
            $data['fuel']['firstZoneFuel'] += $shiftData[$i]->first_zone_fuel;
            $data['fuel']['secondZoneFuel'] += $shiftData[$i]->second_zone_fuel;
            $data['fuel']['allFuel'] += ($shiftData[$i]->first_zone_fuel +
                $shiftData[$i]->second_zone_fuel);
            $data['gas']['thirdZoneGas'] += $shiftData[$i]->third_zone_gas;
            $data['gas']['burnerGas'] += $shiftData[$i]->burner_gas;
            $data['gas']['allGas'] += ($shiftData[$i]->third_zone_gas +
                $shiftData[$i]->burner_gas);

            if ($data['processedCarbon'] >= 1000) {   
                array_push($statistics, $data);
                $data = [
                    'measurementNumbers' => [],
                    'measurements' => [],
                    'energy' => [
                        'drumDriveEnergy' => 0,
                        'firstCompressorEnergy' => 0,
                        'secondCompressorEnergy' => 0,
                        'thirdCompressorEnergy' => 0,
                        'additionalFunctionsEnergy' => 0,
                        'allEnergy' => 0
                    ],
                    'fuel' => [
                        'firstZoneFuel' => 0,
                        'secondZoneFuel' => 0,
                        'allFuel' => 0
                    ],
                    'gas' => [
                        'thirdZoneGas' => 0,
                        'burnerGas' => 0,
                        'allGas' => 0
                    ],
                    'processedCarbon' => 0
                ];
            }
        }

        return $statistics;  
    }

    public function getAllLineEnergyPerShift($shiftIdArr, $enterpriseDay)
    {
        $data = $this->repository->getByShiftIdArr($shiftIdArr, $enterpriseDay);
        $dataRowsCount = count($data);
        $allLineDrumDriveEnergyPerShift = 0;
        $allLineFirstCompressorEnergyPerShift = 0;
        $allLineSecondCompressorEnergyPerShift = 0;
        $allLineThirdCompressorEnergyPerShift = 0;
        $allLineAdditionalFunctionsEnergyPerShift = 0;

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $allLineDrumDriveEnergyPerShift += $data[$i]->drum_drive_energy;
            $allLineFirstCompressorEnergyPerShift += $data[$i]->first_compressor_energy;
            $allLineSecondCompressorEnergyPerShift += $data[$i]->second_compressor_energy;
            $allLineThirdCompressorEnergyPerShift += $data[$i]->third_compressor_energy;
            $allLineAdditionalFunctionsEnergyPerShift += $data[$i]->additional_functions_energy;
        }

        $allLineEnergyPerShift = $allLineDrumDriveEnergyPerShift +
            $allLineFirstCompressorEnergyPerShift +
            $allLineSecondCompressorEnergyPerShift +
            $allLineThirdCompressorEnergyPerShift +
            $allLineAdditionalFunctionsEnergyPerShift; 

        $statistics = [
            'allLineDrumDriveEnergyPerShift' => $allLineDrumDriveEnergyPerShift,
            'allLineFirstCompressorEnergyPerShift' => $allLineFirstCompressorEnergyPerShift,
            'allLineSecondCompressorEnergyPerShift' => $allLineSecondCompressorEnergyPerShift,
            'allLineThirdCompressorEnergyPerShift' => $allLineThirdCompressorEnergyPerShift,
            'allLineAdditionalFunctionsEnergyPerShift' => $allLineAdditionalFunctionsEnergyPerShift,
            'allLineEnergyPerShift' => $allLineEnergyPerShift
        ];

        return $statistics;
        
    }

    public function getAllLineFuelPerShift($shiftIdArr, $enterpriseDay)
    {
        $data = $this->repository->getByShiftIdArr($shiftIdArr, $enterpriseDay);
        $dataRowsCount = count($data);
        $allLineFirstZoneFuelPerShift = 0;
        $allLineSecondZoneFuelPerShift = 0;

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $allLineFirstZoneFuelPerShift += $data[$i]->first_zone_fuel;
            $allLineSecondZoneFuelPerShift += $data[$i]->second_zone_fuel;
        }

        $allLineFuelPerShift = $allLineFirstZoneFuelPerShift +
            $allLineSecondZoneFuelPerShift; 

        $statistics = [
            'allLineFirstZoneFuelPerShift' => $allLineFirstZoneFuelPerShift,
            'allLineSecondZoneFuelPerShift' => $allLineSecondZoneFuelPerShift,
            'allLineFuelPerShift' => $allLineFuelPerShift
        ];

        return $statistics;
        
    }

    public function getAllLineGasPerShift($shiftIdArr, $enterpriseDay)
    {
        $data = $this->repository->getByShiftIdArr($shiftIdArr, $enterpriseDay);
        $dataRowsCount = count($data);
        $allLineThirdZoneGasPerShift = 0;
        $allLineBurnerGasPerShift = 0;

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $allLineThirdZoneGasPerShift += $data[$i]->third_zone_gas;
            $allLineBurnerGasPerShift += $data[$i]->burner_gas;
        }

        $allLineGasPerShift = $allLineThirdZoneGasPerShift +
            $allLineBurnerGasPerShift; 

        $statistics = [
            'allLineThirdZoneGasPerShift' => $allLineThirdZoneGasPerShift,
            'allLineBurnerGasPerShift' => $allLineBurnerGasPerShift,
            'allLineGasPerShift' => $allLineGasPerShift
        ];

        return $statistics;
        
    }

    public function getFuelPerShift($shiftId, $enterpriseDay)
    {
        $shiftData = $this->repository->getShiftData($shiftId, $enterpriseDay);
        $dataRowsCount = count($shiftData);
        $firstZoneFuelPerShift = 0;
        $secondZoneFuelPerShift = 0;

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $firstZoneFuelPerShift += $shiftData[$i]->first_zone_fuel;
            $secondZoneFuelPerShift += $shiftData[$i]->second_zone_fuel;
        }

        $fuelPerShift = $firstZoneFuelPerShift +
            $secondZoneFuelPerShift; 

        $statistics = [
            'firstZoneFuelPerShift' => $firstZoneFuelPerShift,
            'secondZoneFuelPerShift' => $secondZoneFuelPerShift,
            'fuelPerShift' => $fuelPerShift
        ];

        return $statistics;
    }

    public function getGasPerShift($shiftId, $enterpriseDay)
    {
        $shiftData = $this->repository->getShiftData($shiftId, $enterpriseDay);
        $dataRowsCount = count($shiftData);
        $thirdZoneGasPerShift = 0;
        $burnerGasPerShift = 0;

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $thirdZoneGasPerShift += $shiftData[$i]->third_zone_gas;
            $burnerGasPerShift += $shiftData[$i]->burner_gas;
        }

        $gasPerShift = $thirdZoneGasPerShift +
            $burnerGasPerShift; 

        $statistics = [
            'thirdZoneGasPerShift' => $thirdZoneGasPerShift,
            'burnerGasPerShift' => $burnerGasPerShift,
            'gasPerShift' => $gasPerShift
        ];

        return $statistics;
    }

    public function getByDayId(int $dayId)
    {
        return $this->repository->getByDayId($dayId);
    } 

    public function getByShiftId(int $shiftId)
    {
        return $this->repository->getByShiftId($shiftId);
    } 

    public function getByDayShiftId($dayId, $shiftId)
    {
        return $this->repository->getByDayShiftId($dayId, $shiftId);
    }

    public function getByShiftsIdArr($shiftsIdArr)
    {
        return $this->repository->getByShiftsIdArr($shiftsIdArr);
    }
}
