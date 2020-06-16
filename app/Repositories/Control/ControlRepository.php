<?php

namespace App\Repositories\Control;

use App\Repositories\AbstractRepository;
use App\Models\Control;

/**
 * Class ControlRepository.
 */
class ControlRepository extends AbstractRepository implements ControlInterface
{
    public function __construct(Control $control)
    {
        $this->model = $control;
    }

    public function getShiftData($shiftId, $enterpriseDay)
    {
        return $this->model->where([
        	'shift_id' => $shiftId,
        	'enterprise_day_id' => $enterpriseDay
        ])->get();
    }

    public function getByShiftsIdArr($shiftsIdArr)
    {
        return $this->model->
            whereIn('shift_id', $shiftsIdArr)->
            get();
    }

    public function getDataByDays($daysArr)
    {
        return $this->model->
            whereIn('enterprise_day_id', $daysArr)->
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
