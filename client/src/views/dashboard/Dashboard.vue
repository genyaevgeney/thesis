<template>
  <div class="Dashboard">
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('energy-modal')">
        <span>Витрати енергії за зміну</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('fuel-modal')">
        <span>Витрати пального за зміну</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('gas-modal')">
        <span>Витрати газу за зміну</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('cost-modal')">
        <span>Питомі витрати</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('all-energy-modal')">
        <span>Витрати енергії на підприємстві</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('all-fuel-modal')">
        <span>Витрати пального на підприємстві</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('all-gas-modal')">
        <span>Витрати газу на підприємстві</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('shifts-energy-modal')">
        <span>Витрати енергії за зміни</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('shifts-fuel-modal')">
        <span>Витрати пального за зміни</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('shifts-gas-modal')">
        <span>Витрати газу за зміни</span>
    </div>
    <div class="Dashboard__item hover-scale-shadow" @click="showModal('carbon-modal')">
        <span>Параметри якості технічного вуглецю</span>
    </div>
    
    <!-- <span @click="test">test</span> -->




    <modal name="energy-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="radio" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getEnergyPerShift">Розрахувати витрати енергії за зміну</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати приводу барабана: <span class="group-result-value">{{calculationResult.drumDriveEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати першого компресора: <span class="group-result-value">{{calculationResult.firstCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати другого компресора: <span class="group-result-value">{{calculationResult.secondCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати третього компресора: <span class="group-result-value">{{calculationResult.thirdCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Додаткові витрати: <span class="group-result-value">{{calculationResult.additionalFunctionsEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрачено енергії за зміну: <span class="group-result-value">{{calculationResult.energyPerShift}}</span></span>
      </div>
    </modal>




    <modal name="fuel-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="radio" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getFuelPerShift">Розрахувати витрати пального за зміну</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати пальника першої зони: <span class="group-result-value">{{calculationResult.firstZoneFuelPerShift}}</span></span>
        <span class="group-result-line">Витрати пальника другої зони: <span class="group-result-value">{{calculationResult.secondZoneFuelPerShift}}</span></span>
        <span class="group-result-line">Витрачено пального за зміну: <span class="group-result-value">{{calculationResult.fuelPerShift}}</span></span>
      </div>
    </modal>





    <modal name="gas-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="radio" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getGasPerShift">Розрахувати витрати газу за зміну</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати пальника третьої зони: <span class="group-result-value">{{calculationResult.thirdZoneGasPerShift}}</span></span>
        <span class="group-result-line">Витрати аксіального пальника: <span class="group-result-value">{{calculationResult.burnerGasPerShift}}</span></span>
        <span class="group-result-line">Витрачено газу за зміну: <span class="group-result-value">{{calculationResult.gasPerShift}}</span></span>
      </div>
    </modal>



    <modal name="cost-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="radio" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getUnitCostsPerShift">Розрахувати питомі витрати за зміну</div>
      <div v-if="calculationResult" class="group-result">
        <div class="unit-list">
          <span v-for="(item, index) in calculationResult" :key="index" @click="showUnitModal(item)">Розрахунок {{index + 1}}</span>
        </div>
      </div>
    </modal>





    <modal v-if="unitItem" name="unit-modal" class="site-modal">
      <div class="unit-main">
        <span class="unit-heading">Енергія</span>
        <div class="unit-values">
          <span class="group-result-line">Витрати приводу барабана: <span class="group-result-value">{{unitItem.energy.drumDriveEnergy}}</span></span>
          <span class="group-result-line">Витрати першого компресора: <span class="group-result-value">{{unitItem.energy.firstCompressorEnergy}}</span></span>
          <span class="group-result-line">Витрати другого компресора: <span class="group-result-value">{{unitItem.energy.secondCompressorEnergy}}</span></span>
          <span class="group-result-line">Витрати третього компресора: <span class="group-result-value">{{unitItem.energy.thirdCompressorEnergy}}</span></span>
          <span class="group-result-line">Додаткові витрати: <span class="group-result-value">{{unitItem.energy.additionalFunctionsEnergy}}</span></span>
          <span class="group-result-line">Витрачено енергії: <span class="group-result-value">{{unitItem.energy.allEnergy}}</span></span>
        </div>
        <span class="unit-heading">Пальне</span>
        <div class="unit-values">
          <span class="group-result-line">Витрати пальника першої зони: <span class="group-result-value">{{unitItem.fuel.firstZoneFuel}}</span></span>
          <span class="group-result-line">Витрати пальника другої зони: <span class="group-result-value">{{unitItem.fuel.secondZoneFuel}}</span></span>
          <span class="group-result-line">Витрачено пального: <span class="group-result-value">{{unitItem.fuel.allFuel}}</span></span>
        </div>
        <span class="unit-heading">Газ</span>
        <div class="unit-values">
          <span class="group-result-line">Витрати пальника третьої зони: <span class="group-result-value">{{unitItem.gas.thirdZoneGas}}</span></span>
          <span class="group-result-line">Витрати аксіального пальника: <span class="group-result-value">{{unitItem.gas.burnerGas}}</span></span>
          <span class="group-result-line">Витрачено газу: <span class="group-result-value">{{unitItem.gas.allGas}}</span></span>
        </div>
        <div class="unit-list unit">
          <template v-for="(measurement, index) in unitItem.measurements">
            <span @click="showMeasurementModal(measurement)" :key="index">Вимірювання {{unitItem.measurementNumbers[index]}}</span>
          </template>
        </div>
        <span class="unit-heading">Оброблено вуглецю: <span class="unit-carbon">{{unitItem.processedCarbon}}</span></span>
      </div>
    </modal>










    <modal v-if="measurement" name="measurement-modal" class="site-modal modal-measurement">
      <div class="measurement-main">
        <div><span class="measurement-prop">День: </span><span class="measurement-value">{{measurement.enterprise_day_id}}</span></div>
        <div><span class="measurement-prop">Зміна: </span><span class="measurement-value">{{measurement.shift_id}}</span></div>
        <div><span class="measurement-prop">Вологість: </span><span class="measurement-value">{{measurement.humidity}}</span></div>
        <div><span class="measurement-prop">Температура: </span><span class="measurement-value">{{measurement.temperature}}</span></div>
        <div><span class="measurement-prop">Оберти барабану: </span><span class="measurement-value">{{measurement.drum_speed}}</span></div>
        <div><span class="measurement-prop">Оброблено вуглецю: </span><span class="measurement-value">{{measurement.processed_carbon}}</span></div>
        <div><span class="measurement-prop">Пальне 1 зони: </span><span class="measurement-value">{{measurement.first_zone_fuel}}</span></div>
        <div><span class="measurement-prop">Пальне 2 зони: </span><span class="measurement-value">{{measurement.second_zone_fuel}}</span></div>
        <div><span class="measurement-prop">Газ 3 зони: </span><span class="measurement-value">{{measurement.third_zone_gas}}</span></div>
        <div><span class="measurement-prop">Газ аксіального пальника: </span><span class="measurement-value">{{measurement.burner_gas}}</span></div>
        <div><span class="measurement-prop">Енергія приводу: </span><span class="measurement-value">{{measurement.drum_drive_energy}}</span></div>
        <div><span class="measurement-prop">Енергія 1 компресору: </span><span class="measurement-value">{{measurement.first_compressor_energy}}</span></div>
        <div><span class="measurement-prop">Енергія 2 компресору: </span><span class="measurement-value">{{measurement.second_compressor_energy}}</span></div>
        <div><span class="measurement-prop">Енергія 3 компресору: </span><span class="measurement-value">{{measurement.third_compressor_energy}}</span></div>
        <div><span class="measurement-prop">Додаткова енергія: </span><span class="measurement-value">{{measurement.additional_functions_energy}}</span></div>
        <div><span class="measurement-prop">Воднево-міласовий розчин: </span><span class="measurement-value">{{measurement.water_solution}}</span></div>
        <div><span class="measurement-prop">Дата: </span><span class="measurement-value">{{measurement.created_at}}</span></div>
      </div>
    </modal>





    <modal name="all-energy-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label>
            <input type="radio" value="Рання зміна" v-model="firstGroup">
            <span>Рання зміна</span>
          </label>
          <label>
            <input type="radio" value="Денна зміна" v-model="firstGroup">
            <span>Денна зміна</span>
          </label>
          <label>
            <input type="radio" value="Нічна зміна" v-model="firstGroup">
            <span>Нічна зміна</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getAllLineEnergyPerShift">Розрахувати витрати енергії</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати приводу барабана: <span class="group-result-value">{{calculationResult.allLineDrumDriveEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати першого компресора: <span class="group-result-value">{{calculationResult.allLineFirstCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати другого компресора: <span class="group-result-value">{{calculationResult.allLineSecondCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати третього компресора: <span class="group-result-value">{{calculationResult.allLineThirdCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Додаткові витрати: <span class="group-result-value">{{calculationResult.allLineAdditionalFunctionsEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрачено енергії за зміну: <span class="group-result-value">{{calculationResult.allLineEnergyPerShift}}</span></span>
      </div>
    </modal>




    <modal name="all-fuel-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label>
            <input type="radio" value="Рання зміна" v-model="firstGroup">
            <span>Рання зміна</span>
          </label>
          <label>
            <input type="radio" value="Денна зміна" v-model="firstGroup">
            <span>Денна зміна</span>
          </label>
          <label>
            <input type="radio" value="Нічна зміна" v-model="firstGroup">
            <span>Нічна зміна</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getAllLineFuelPerShift">Розрахувати витрати пального</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати пальника першої зони: <span class="group-result-value">{{calculationResult.allLineFirstZoneFuelPerShift}}</span></span>
        <span class="group-result-line">Витрати пальника другої зони: <span class="group-result-value">{{calculationResult.allLineSecondZoneFuelPerShift}}</span></span>
        <span class="group-result-line">Витрачено пального за зміну: <span class="group-result-value">{{calculationResult.allLineFuelPerShift}}</span></span>
      </div>
    </modal>






    <modal name="all-gas-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label>
            <input type="radio" value="Рання зміна" v-model="firstGroup">
            <span>Рання зміна</span>
          </label>
          <label>
            <input type="radio" value="Денна зміна" v-model="firstGroup">
            <span>Денна зміна</span>
          </label>
          <label>
            <input type="radio" value="Нічна зміна" v-model="firstGroup">
            <span>Нічна зміна</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getAllLineGasPerShift">Розрахувати витрати газу</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати пальника третьої зони: <span class="group-result-value">{{calculationResult.allLineThirdZoneGasPerShift}}</span></span>
        <span class="group-result-line">Витрати аксіального пальника: <span class="group-result-value">{{calculationResult.allLineBurnerGasPerShift}}</span></span>
        <span class="group-result-line">Витрачено газу за зміну: <span class="group-result-value">{{calculationResult.allLineGasPerShift}}</span></span>
      </div>
    </modal>





    <modal name="shifts-energy-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміни підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="checkbox" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getShiftsEnergy">Розрахувати витрати енергії за зміни</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати приводу барабана: <span class="group-result-value">{{calculationResult.allLineDrumDriveEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати першого компресора: <span class="group-result-value">{{calculationResult.allLineFirstCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати другого компресора: <span class="group-result-value">{{calculationResult.allLineSecondCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрати третього компресора: <span class="group-result-value">{{calculationResult.allLineThirdCompressorEnergyPerShift}}</span></span>
        <span class="group-result-line">Додаткові витрати: <span class="group-result-value">{{calculationResult.allLineAdditionalFunctionsEnergyPerShift}}</span></span>
        <span class="group-result-line">Витрачено енергії за зміну: <span class="group-result-value">{{calculationResult.allLineEnergyPerShift}}</span></span>
      </div>
    </modal>





    <modal name="shifts-fuel-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміни підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="checkbox" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getShiftsFuel">Розрахувати витрати пального за зміни</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати пальника першої зони: <span class="group-result-value">{{calculationResult.allLineFirstZoneFuelPerShift}}</span></span>
        <span class="group-result-line">Витрати пальника другої зони: <span class="group-result-value">{{calculationResult.allLineSecondZoneFuelPerShift}}</span></span>
        <span class="group-result-line">Витрачено пального за зміну: <span class="group-result-value">{{calculationResult.allLineFuelPerShift}}</span></span>
      </div>
    </modal>




    <modal name="shifts-gas-modal" class="site-modal">
      <div class="group">
        <span class="group-name">Оберіть зміни підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="checkbox" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="getShiftsGas">Розрахувати витрати газу за зміни</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Витрати пальника третьої зони: <span class="group-result-value">{{calculationResult.allLineThirdZoneGasPerShift}}</span></span>
        <span class="group-result-line">Витрати аксіального пальника: <span class="group-result-value">{{calculationResult.allLineBurnerGasPerShift}}</span></span>
        <span class="group-result-line">Витрачено газу за зміну: <span class="group-result-value">{{calculationResult.allLineGasPerShift}}</span></span>
      </div>
    </modal>








    <modal name="carbon-modal" class="site-modal carbon">
      <div class="group">
        <span class="group-name">Оберіть зміну підприємства:</span>
        <div class="group-list">
          <label v-for="(shift, index) in shifts" :key="index">
            <input type="radio" :value="shift.id" v-model="firstGroup">
            <span>Зміна #{{shift.id}} ({{shift.name}}) | Лінія #{{shift.line_id}}</span>
          </label>
        </div>
      </div>
      <div class="group">
        <span class="group-name">Оберіть день підприємства:</span>
        <div class="group-list">
          <label v-for="(day, index) in days" :key="index">
            <input type="radio" :value="day.id" v-model="secondGroup">
            <span>День #{{day.id}}</span>
          </label>
        </div>
      </div>
      <div class="group-btn" @click="calculateCarbonQuality">Розрахувати параметри вуглецю</div>
      <div v-if="calculationResult" class="group-result">
        <span class="group-result-line">Марка: <span class="group-result-value">{{calculationResult.mark}}</span></span>
        <span class="group-result-line">Вологість: <span class="group-result-value">{{calculationResult.humidity}}</span></span>
        <span class="group-result-line">Питома площа поверхні: <span class="group-result-value">{{calculationResult.specificSurfaceArea}}</span></span>
        <span class="group-result-line">Йодне число: <span class="group-result-value">{{calculationResult.iodineNumber}}</span></span>
        <span class="group-result-line">Абсорбція масла: <span class="group-result-value">{{calculationResult.oilAbsorption}}</span></span>
        <span class="group-result-line">Насипна щільність: <span class="group-result-value">{{calculationResult.bulkDensity}}</span></span>
        <span class="group-result-line">Розмір гранул: <span class="group-result-value">{{calculationResult.granuleSize}}</span></span>
        <span class="group-result-line">Опір стиранню: <span class="group-result-value">{{calculationResult.abrasionResistance}}</span></span>
        <span class="group-result-line">Температура на виході: <span class="group-result-value">{{calculationResult.drumOutletTemperature}}</span></span>
      </div>
    </modal>
  </div>
</template>

<script>
  import axios from "axios";
  export default {
    name: 'DashboardDashboard',

    data () {
      return {
        shifts: [],
        days: [],
        calculationResult: null,
        firstGroup: [],
        secondGroup: [],
        unitItem: null,
        measurement: null
      }
    },
    mounted() {
      this.loadPageData(this.$route.params.num);
    },
    methods: {
      clickLine(lineName, lineId) {
        this.lineName = lineName;
        this.lineId = lineId;
        this.$modal.show('line-modal');
      },
      test () {
        console.log("this.firstGroup", this.firstGroup);
        console.log("this.shifts", this.shifts);
        console.log("this.days", this.days);
      },
      loadPageData(pageNum) {
        axios
          .get(
            `${process.env.VUE_APP_URL}/api/shifts`
          )
          .then(response => {
            this.shifts = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
        axios
          .get(
            `${process.env.VUE_APP_URL}/api/enterprise-days`
          )
          .then(response => {
            this.days = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getEnergyPerShift() {
        let data = {
          shiftId: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/energy-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getAllLineEnergyPerShift() {
        let shiftIdArr = [];
        this.shifts.forEach((item) => {
          if (item.name == this.firstGroup) {
            shiftIdArr.push(item.id);
          }
        })
        let data = {
          shiftIdArr: shiftIdArr,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/shifts-energy-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getShiftsEnergy() {
        let data = {
          shiftIdArr: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/shifts-energy-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getShiftsFuel() {
        let data = {
          shiftIdArr: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/shifts-fuel-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getShiftsGas() {
        let data = {
          shiftIdArr: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/shifts-gas-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getFuelPerShift() {
        let data = {
          shiftId: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/fuel-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getAllLineFuelPerShift() {
        let shiftIdArr = [];
        this.shifts.forEach((item) => {
          if (item.name == this.firstGroup) {
            shiftIdArr.push(item.id);
          }
        })
        let data = {
          shiftIdArr: shiftIdArr,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/shifts-fuel-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getGasPerShift() {
        let data = {
          shiftId: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/gas-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      calculateCarbonQuality() {
        let data = {
          shiftId: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/carbon-params`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getAllLineGasPerShift() {
        let shiftIdArr = [];
        this.shifts.forEach((item) => {
          if (item.name == this.firstGroup) {
            shiftIdArr.push(item.id);
          }
        })
        let data = {
          shiftIdArr: shiftIdArr,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/shifts-gas-costs`, data
          )
          .then(response => {
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      getUnitCostsPerShift() {
        let data = {
          shiftId: this.firstGroup,
          enterpriseDay: this.secondGroup
        }
        axios
          .post(
            `${process.env.VUE_APP_URL}/api/calculate/unit-costs`, data
          )
          .then(response => {
            console.log(response.data)
            this.calculationResult = response.data;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      showModal(modalName) {
        this.calculationResult = null;
        this.firstGroup = [];
        this.secondGroup = [];
        this.$modal.show(modalName);
      }, 
      showUnitModal(item) {
        this.unitItem = item;
        this.$modal.show('unit-modal');
      },
      showMeasurementModal(measurement) {
        console.log(measurement);
        this.measurement = measurement;
        this.$modal.show('measurement-modal');
      }
    },
  }
</script>

<style lang="scss">
.Dashboard {
  display: flex;
  justify-content: space-between;
  padding: 20px 10%;
  flex-wrap:wrap;
  &__item {
    background-color: white;
    color:black;
    text-decoration:none;
    width: 48%;
    margin-bottom: 30px;

    &:hover {
      cursor:pointer;
    }

    & > * {
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 22px;
      padding: 15px 0;
    }

    span {
      font-family: "Sylfaen", sans-serif;
    }
  }

  .site-modal {
    display: flex;
    justify-content: center;
    align-items: center;

    [role="dialog"] {
      padding:20px 15px;
      height:auto !important;
      position:relative !important;
      top:0 !important;
      left:0 !important;
    }

    &.modal-measurement {
      [role="dialog"] {
        width:auto !important;
        align-items: flex-start;
      }

      .measurement-main {
        border:1px solid silver;
        padding: 8px;
      }

      .measurement-prop {
        font-family: "Sylfaen", sans-serif;
        font-weight: bold;
        font-size:17px;
      }

      .measurement-value {
        font-family: "BebasNeue-Book";
        font-size:17px;
      }
    }

    &.carbon {
      [role="dialog"] {
        width:715px !important;
      }
    }

    .group-name {
      font-size: 17px;
      font-family: "Sylfaen", sans-serif;
      margin-bottom: 5px;
      display: block;
    }

    .group {
      &:not(:last-child) {
        margin-bottom: 5px;
      }
      width:100%;
    }

    .group-btn {
      font-family: "Sylfaen", sans-serif;
      margin-top: 10px;
      padding: 10px;
      background-color: #2F2F30;
      color:white;
      transition: opacity .3s ease;
      cursor:pointer;
      margin-bottom: 10px;
      &:hover {
        opacity:.7;
      }
    }

    .group-result {
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 17px;
    }

    .group-result-line { 
      font-family: "Sylfaen", sans-serif; 
    }

    .group-result-value { 
      font-family: "BebasNeue-Book";
    }

    .group-list {
      display: flex;
      flex-wrap: wrap;

      label {
        
        &:not(:last-child) {
          margin-right: 10px;
        }
        
        span {
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
          border:1px solid silver;
          font-family: "Sylfaen", sans-serif;
          font-size: 14px;
          padding:2px 4px;
          cursor:pointer;
          transition: opacity .3s ease;
          &:hover {
            opacity:.7;
          }
        }

        input {
          display:none;
          &:checked + span {
           background-color: #4caf50;
           color:white;
          }
          
        }
      }
    }

    .unit-list {
      display: flex;
      flex-wrap: wrap;

      &.unit {
        margin-top: 10px;
      }

      span {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        border:1px solid silver;
        font-family: "Sylfaen", sans-serif;
        font-size: 14px;
        padding:2px 4px;
        cursor:pointer;
        transition: opacity .3s ease;
        margin-bottom: 5px;
        &:hover {
          opacity:.7;
        }
        &:not(:last-child) {
          margin-right: 10px;
        }
      }     
    }

    .unit-main {
      font-family: "Sylfaen", sans-serif;
      display: flex;
      flex-direction: column;
      width:100%;
    }

    .unit-heading {
      font-weight: bold;
      font-size:18px;
    }
    
    .unit-carbon {
      font-weight: normal;
      font-size:18px;
      font-family: "BebasNeue-Book";
    }

    .unit-values {
      display: flex;
      flex-direction: column;
      border:1px solid silver;
      padding: 5px;
    }
  }
}
</style>
