<?php

namespace App\Services\Sensor;

use App\Services\AbstractInterface;

interface SensorInterface extends AbstractInterface
{
	public function getEnergyPerShift($shiftId, $enterpriseDay);

	public function getUnitCostsPerShift($shiftId, $enterpriseDay);

	public function getAllLineEnergyPerShift($shiftIdArr, $enterpriseDay);

	public function getAllLineFuelPerShift($shiftIdArr, $enterpriseDay);

	public function getAllLineGasPerShift($shiftIdArr, $enterpriseDay);

	public function getFuelPerShift($shiftId, $enterpriseDay);

	public function getGasPerShift($shiftId, $enterpriseDay);

	public function getByDayId(int $dayId);

	public function getByShiftId(int $shiftId);

	public function getByDayShiftId($dayId, $shiftId);

	public function getByShiftsIdArr($shiftsIdArr);
}
