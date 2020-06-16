<?php

namespace App\Repositories\Shift;

use App\Repositories\AbstractRepository;
use App\Models\Shift;

/**
 * Class SiteRepository.
 */
class ShiftRepository extends AbstractRepository implements ShiftInterface
{
    public function __construct(Shift $shift)
    {
        $this->model = $shift;
    }

    public function getByLineId(int $lineId)
    {
        return $this->model->where('line_id', $lineId)->get();
    }
}
