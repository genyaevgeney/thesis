<?php

namespace App\Services\Line;

use App\Repositories\Line\LineRepository;
use App\Services\AbstractService;

class LineService extends AbstractService implements LineInterface
{
    /**
     * Initialize class properties
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(LineRepository $lineRepository)
    {
        $this->repository = $lineRepository;
    }
}