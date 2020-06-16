<?php

namespace App\Http\Controllers;

use App\Services\Enterprise\EnterpriseService;

class EnterpriseController extends Controller
{
    protected $service;

    public function __construct(EnterpriseService $enterpriseService)
    {
        $this->service = $enterpriseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        // $this->service->getEnergyPerShift(13, 1);
        // $this->service->getFuelPerShift(4, 2);
        // $this->service->getGasPerShift(4, 2);
        // $this->service->getUnitCostsPerShift(4, 2);
        // $this->service->getAllLineEnergyPerShift([1, 4, 7, 10, 13], 1);
        // $this->service->getAllLineFuelPerShift([1, 4, 7, 10, 13], 1);
        // $this->service->getAllLineGasPerShift([1, 4, 7, 10, 13], 1);
        $this->service->generateEnterpriseDay();
        // $this->controlService->calculateCarbonBlackQualityParametersPerShift(11, 2);
    }

    public function generateDay()
    {
        $this->service->generateEnterpriseDay();
    }
}
