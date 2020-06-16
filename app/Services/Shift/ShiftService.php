<?php

namespace App\Services\Shift;

use App\Repositories\Shift\ShiftRepository;
use App\Services\AbstractService;

class ShiftService extends AbstractService implements ShiftInterface
{
    /**
     * Initialize class properties
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->repository = $shiftRepository;
    }

    public function getByLineId(int $lineId)
    {
        return $this->repository->getByLineId($lineId);
    } 
}
