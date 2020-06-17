<template>
  <div class="main">
    <div class="group">
      <span class="group-name">Оберіть параметр технічного вуглецю:</span>
      <div class="group-list">
        <label v-for="(param, index) in params" :key="index">
          <input type="radio" :value="param" v-model="firstGroup">
          <span>{{param.name}}</span>
        </label>
      </div>
    </div>
    <div class="group">
      <span class="group-name">Оберіть дні підприємства:</span>
      <div class="group-list">
        <label v-for="(day, index) in days" :key="index">
          <input type="checkbox" :value="day.id" v-model="secondGroup">
          <span>День #{{day.id}}</span>
        </label>
      </div>
    </div>
    <div class="group-btn" @click="createCard">Створити карти Шухарта</div>
    <GChart
      v-if="showChart"
      type="LineChart"
      :data="chartData"
      :options="chartOptions1"
      style="margin-bottom: 30px;"
    />
    <GChart
      v-if="showChart"
      type="LineChart"
      :data="chartData2"
      :options="chartOptions2"
    />
  </div>
</template>

<script>
  import { GChart } from 'vue-google-charts'
  import axios from "axios";

  export default {
    data () {
      return {
        chartData: [],
        chartOptions1: {
            title: 'Карта середніх',
            height:500,
        },
        chartOptions2: {
            title: 'Карта розмахів',
            height:500,
        },
        days: [],
        params: [{name: 'Опір стиранню', value: 'abrasion_resistance'}, {name: 'Насипна щільність', value: 'bulk_density'}, {name: 'Температура на виході', value: 'drum_outlet_temperature'}, {name: 'Розмір гранул', value: 'granule_size'}, {name: 'Вологість', value: 'humidity'}, {name: 'Йодне число', value: 'iodine_number'}, {name: 'Абсорбція масла', value: 'oil_absorption'}, {name: 'Питома площа поверхні', value: 'specific_surface_area'}],
        controls: null,
        firstGroup: [],
        secondGroup: [],
        dataArr: [],
        bottomValues: [],
        leftValues: [],
        sizeArr: 4,
        showChart: false,
        leftValues2: [],
        chartData2: [],
        RCenter: 0,
        RUCL: 0,
        RLCL: 0,
        D4: 2.282,
        D3: 0,
        RU: 0,
        RL: 0,
        RN: 0,
        XCenter: 0,
        XUCL: 0,
        XLCL: 0,
        A2: 0.729,
      }
    },
    components: {
      GChart
    },
    mounted() {
    this.loadPageData();
  },
  methods: {
    loadPageData() {
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
    createCard() {
      this.bottomValues = [];
      this.leftValues = [];
      this.leftValues2 = [];
      this.getDataByDays();
    },
    getDataByDays() {
      let data = {
        daysArr: this.secondGroup
      }
      axios
        .post(
          `${process.env.VUE_APP_URL}/api/controls-card`, data
        )
        .then(response => {
          this.controls = response.data;
          console.log('this.controls', this.controls);
          console.log('this.firstGroup', this.firstGroup)
          this.changeControlsArr();
          console.log('this.dataArr', this.dataArr);
          this.dataArr.forEach((item) => {
            this.bottomValues.push(`День ${item[0].enterprise_day_id} - Зміна ${item[0].shift_id}`);
            let value = 0;
            let arr2 = [];
            item.forEach((i) => {
              value += i[this.firstGroup.value];
              arr2.push(i[this.firstGroup.value]);
            });
            this.leftValues.push(value/this.sizeArr);
            this.leftValues2.push(Math.max(...arr2) - Math.min(...arr2));
          })
          this.RCenter = (this.leftValues2.reduce((a, b) => a + b, 0))/this.leftValues2.length;
          this.RUCL = this.D4 * this.RCenter;
          this.RLCL = this.D3 * this.RCenter;
          this.RU = Math.max(...this.leftValues2) + (Math.max(...this.leftValues2)/100*20);
          this.RL = Math.min(...this.leftValues2) - (Math.min(...this.leftValues2)/100*20);
          this.RN = (this.RU + this.RL)/2;
          this.XCenter = (this.leftValues.reduce((a, b) => a + b, 0))/this.leftValues.length;
          this.XUCL = this.XCenter + (this.A2*this.RCenter);
          this.XLCL = this.XCenter - (this.A2*this.RCenter);
          this.XU = Math.max(...this.leftValues) + (Math.max(...this.leftValues)/100*20);
          this.XL = Math.min(...this.leftValues) - (Math.min(...this.leftValues)/100*20);
          this.XN = (this.XU + this.XL)/2;
          console.log("this.bottomValues", this.bottomValues);
          console.log("this.leftValues", this.leftValues);
          console.log("this.leftValues2", this.leftValues2);
          this.createChartData();
        })
        .catch(error => {
          console.log(error.response.data);
        });
    },
    changeControlsArr() {
      for (let i = 0; i < Math.ceil(this.controls.length/this.sizeArr); i++) {
          this.dataArr[i] = this.controls.slice((i*this.sizeArr), (i*this.sizeArr) + this.sizeArr);
      }
    },
    createChartData() {
      this.chartData = [
        ['День - Зміна', this.firstGroup.name, 'Центральна лінія', 'Верхня контрольна межа', 'Нижня контрольна межа', 'Номінал', 'Верхня межа допуску', 'Нижня межа допуску']
      ];
      this.chartData2 = [
        ['День - Зміна', this.firstGroup.name, 'Центральна лінія', 'Верхня контрольна межа', 'Нижня контрольна межа', 'Номінал', 'Верхня межа допуску', 'Нижня межа допуску']
      ];
      for (let i = 0; i < this.bottomValues.length; i++) {
        this.chartData.push([this.bottomValues[i], this.leftValues[i], this.XCenter, this.XUCL, this.XLCL, this.XN, this.XU, this.XL]);
        this.chartData2.push([this.bottomValues[i], this.leftValues2[i], this.RCenter, this.RUCL, this.RLCL, this.RN, this.RU, this.RL]);
      }
      this.showChart = true;
    }
  }
  }
</script>

<style lang="scss" scoped>
  .main {
    padding: 0 8px 8px;
  }

  .group-btn {
    font-family: "Sylfaen", sans-serif;
    margin-top: 10px;
    padding: 10px;
    background-color: #2F2F30;
    display: inline-block;
    color:white;
    transition: opacity .3s ease;
    cursor:pointer;
    margin-bottom: 10px;
    &:hover {
      opacity:.7;
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
</style>
