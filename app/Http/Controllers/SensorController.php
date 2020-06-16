<?php

namespace App\Http\Controllers;

use App\Services\Sensor\SensorService;
use App\Services\Shift\ShiftService;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    protected $service;

    protected $shiftService;

    public function __construct(SensorService $sensorService, ShiftService $shiftService)
    {
        $this->service = $sensorService;
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

    public function getEnergyPerShift(Request $request) {
        return $this->service->getEnergyPerShift($request->shiftId, $request->enterpriseDay);
    }

    public function getFuelPerShift(Request $request) {
        return $this->service->getFuelPerShift($request->shiftId, $request->enterpriseDay);
    }

    public function getGasPerShift(Request $request) {
        return $this->service->getGasPerShift($request->shiftId, $request->enterpriseDay);
    }

    public function getUnitCostsPerShift(Request $request) {
        return $this->service->getUnitCostsPerShift($request->shiftId, $request->enterpriseDay);
    }

    public function getAllLineEnergyPerShift(Request $request) {
        return $this->service->getAllLineEnergyPerShift($request->shiftIdArr, $request->enterpriseDay);
    }

    public function getAllLineFuelPerShift(Request $request) {
        return $this->service->getAllLineFuelPerShift($request->shiftIdArr, $request->enterpriseDay);
    }

    public function getAllLineGasPerShift(Request $request) {
        return $this->service->getAllLineGasPerShift($request->shiftIdArr, $request->enterpriseDay);
    }

    
    
}
