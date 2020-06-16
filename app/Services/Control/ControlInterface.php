<?php

namespace App\Services\Control;

use App\Services\AbstractInterface;

interface ControlInterface extends AbstractInterface
{
	public function calculateCarbonBlackQualityParametersPerShift($shiftId, $enterpriseDay);

	public function getByDayId(int $dayId);

	public function getByShiftId(int $shiftId);

	public function getByDayShiftId($dayId, $shiftId);

	public function getByShiftsIdArr($shiftsIdArr);
}
