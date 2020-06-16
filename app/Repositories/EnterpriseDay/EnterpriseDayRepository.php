<?php

namespace App\Repositories\EnterpriseDay;

use App\Repositories\AbstractRepository;
use App\Models\EnterpriseDay;

class EnterpriseDayRepository extends AbstractRepository implements EnterpriseDayInterface
{
    public function __construct(EnterpriseDay $enterpriseDay)
    {
        $this->model = $enterpriseDay;
    }
}
