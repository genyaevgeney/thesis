<?php

namespace App\Repositories\Sensor;

use App\Repositories\AbstractInterface;

interface SensorInterface extends AbstractInterface
{
	public function getShiftData($shiftId, $enterpriseDay);

	public function getByShiftIdArr($shiftIdArr, $enterpriseDay);

	public function getByDayId(int $dayId);

	public function getByShiftId(int $shiftId);

	public function getByDayShiftId($dayId, $shiftId);

	public function getByShiftsIdArr($shiftsIdArr);
}
