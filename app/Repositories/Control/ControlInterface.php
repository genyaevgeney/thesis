<?php

namespace App\Repositories\Control;

use App\Repositories\AbstractInterface;

/**
 * Interface ControlInterface.
 */
interface ControlInterface extends AbstractInterface
{
	public function getShiftData($shiftId, $enterpriseDay);

	public function getByDayId(int $dayId);

	public function getByShiftId(int $shiftId);

	public function getByDayShiftId($dayId, $shiftId);

	public function getByShiftsIdArr($shiftsIdArr);
}
