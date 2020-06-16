<?php

namespace App\Http\Controllers;

use App\Services\Control\ControlService;
use App\Services\Shift\ShiftService;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    protected $service;

    protected $shiftService;

    public function __construct(ControlService $controlService, ShiftService $shiftService)
    {
        $this->service = $controlService;
        $this->shiftService = $shiftService;
    }

    public function show($id)
    {
        $data = $this->service->paginate();
        return response()->json($data, 200);
    }

    public function getByDayId($dayId)
    {
        return $this->service->getByDayId($dayId);
    }

    public function getByShiftId($shiftId)
    {
        return $this->service->getByShiftId($shiftId);
    }

    public function getByDayShiftId($dayId, $shiftId)
    {
        return $this->service->getByDayShiftId($dayId, $shiftId);
    }

    public function getByLineId($lineId)
    {
        $shifts = $this->shiftService->getByLineId($lineId);
        $shiftsIdArr = [];

        for ($i = 0; $i < count($shifts); $i++) { 
            array_push($shiftsIdArr, $shifts[$i]->id);
        }
        
        return $this->service->getByShiftsIdArr($shiftsIdArr);
    }

    public function calculateCarbonQualityParametersPerShift(Request $request) {
        return $this->service->calculateCarbonBlackQualityParametersPerShift($request->shiftId, $request->enterpriseDay);
    }
}
