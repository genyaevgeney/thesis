<?php

namespace App\Repositories\Line;

use App\Repositories\AbstractRepository;
use App\Models\Line;

/**
 * Class SiteRepository.
 */
class LineRepository extends AbstractRepository implements LineInterface
{
    public function __construct(Line $line)
    {
        $this->model = $line;
    }
}
