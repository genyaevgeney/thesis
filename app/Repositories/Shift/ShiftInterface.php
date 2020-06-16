<?php

namespace App\Repositories\Shift;

use App\Repositories\AbstractInterface;

/**
 * Interface SiteInterface.
 */
interface ShiftInterface extends AbstractInterface
{
	public function getByLineId(int $lineId);
}
