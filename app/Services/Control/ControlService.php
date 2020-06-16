<?php

namespace App\Services\Control;

use App\Services\AbstractService;
use App\Repositories\Control\ControlRepository;

class ControlService extends AbstractService implements ControlInterface
{
    
    /**
     * Initialize class properties
     *
     * @param ControlRepository $controlRepository
     */
    public function __construct(ControlRepository $controlRepository)
    {
    	$this->repository = $controlRepository;
        $this->paginationRowsCount = 10;
    }

    public function calculateCarbonBlackQualityParametersPerShift($shiftId, $enterpriseDay)
    {
    	$shiftData = $this->repository->getShiftData($shiftId, $enterpriseDay);
    	$dataRowsCount = count($shiftData);
    	$statistics = [
            'mark' => '',
            'humidity' => 0,
            'specificSurfaceArea' => 0,
            'iodineNumber' => 0,
            'oilAbsorption' => 0,
            'bulkDensity' => 0,
            'granuleSize' => 0,
            'abrasionResistance' => 0,
            'drumOutletTemperature' => 0
        ];

        for ($i = 0; $i < $dataRowsCount; $i++) { 
            $statistics['humidity'] += $shiftData[$i]->humidity;
            $statistics['specificSurfaceArea'] += $shiftData[$i]->specific_surface_area;
            $statistics['iodineNumber'] += $shiftData[$i]->iodine_number;
            $statistics['oilAbsorption'] += $shiftData[$i]->oil_absorption;
            $statistics['bulkDensity'] += $shiftData[$i]->bulk_density;
            $statistics['granuleSize'] += $shiftData[$i]->granule_size;
            $statistics['abrasionResistance'] += $shiftData[$i]->abrasion_resistance;
            $statistics['drumOutletTemperature'] += $shiftData[$i]->drum_outlet_temperature;   

            if ($i === ($dataRowsCount - 1)) {
                $statistics['mark'] = $shiftData[$i]->mark;
            	$statistics['humidity'] /= $dataRowsCount;
            	$statistics['specificSurfaceArea'] /= $dataRowsCount;
            	$statistics['iodineNumber'] /= $dataRowsCount;
            	$statistics['oilAbsorption'] /= $dataRowsCount;
            	$statistics['bulkDensity'] /= $dataRowsCount;
            	$statistics['granuleSize'] /= $dataRowsCount;
            	$statistics['abrasionResistance'] /= $dataRowsCount;
            	$statistics['drumOutletTemperature'] /= $dataRowsCount;   
            }
        }

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

    public function getDataByDays($daysArr)
    {
        return $this->repository->getDataByDays($daysArr);
    }
}
