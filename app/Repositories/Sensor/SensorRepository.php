<?php

namespace App\Repositories\Sensor;

use App\Repositories\AbstractRepository;
use App\Models\Sensor;

class SensorRepository extends AbstractRepository implements SensorInterface
{
    public function __construct(Sensor $sensor)
    {
        $this->model = $sensor;
    }

    public function getShiftData($shiftId, $enterpriseDay)
    {
        return $this->model->where([
        	'shift_id' => $shiftId,
        	'enterprise_day_id' => $enterpriseDay
        ])->get();
    }

    public function getByShiftIdArr($shiftIdArr, $enterpriseDay)
    {
        return $this->model->
            where('enterprise_day_id', $enterpriseDay)->
            whereIn('shift_id', $shiftIdArr)->
            get();
    }

    public function getByShiftsIdArr($shiftsIdArr)
    {
        return $this->model->
            whereIn('shift_id', $shiftsIdArr)->
            get();
    }

    public function getByDayId(int $dayId)
    {
        return $this->model->where('enterprise_day_id', $dayId)->get();
    }

    public function getByShiftId(int $shiftId)
    {
        return $this->model->where('shift_id', $shiftId)->get();
    }

    public function getByDayShiftId($dayId, $shiftId)
    {
        return $this->model->where(['shift_id' => $shiftId, 'enterprise_day_id' => $dayId])->get();
    }
}
