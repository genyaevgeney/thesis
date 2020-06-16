<?php

namespace App\Services\Shift;

use App\Services\AbstractInterface;

interface ShiftInterface extends AbstractInterface
{
	public function getByLineId(int $lineId);
}
