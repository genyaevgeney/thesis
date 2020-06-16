<?php

namespace App\Services\EnterpriseDay;

use App\Repositories\EnterpriseDay\EnterpriseDayRepository;
use App\Services\AbstractService;

class EnterpriseDayService extends AbstractService implements EnterpriseDayInterface
{
    /**
     * Initialize class properties
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(EnterpriseDayRepository $enterpriseDayRepository)
    {
        $this->repository = $enterpriseDayRepository;
    }
}