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
    <div class="group-btn" @click="createCard">Створити карту Шухарта</div>
    <GChart
    v-if="showChart"
    type="LineChart"
    :data="chartData"
    :options="chartOptions"
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
        chartOptions: {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          }
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
        showChart: false
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
      // axios
      //   .get(
      //     `${process.env.VUE_APP_URL}/api/controls-data`
      //   )
      //   .then(response => {
      //     this.controls = response.data;
      //     console.log("Controls", this.controls);
      //     let size = 4; //размер подмассива
      //     for (let i = 0; i <Math.ceil(this.controls.length/size); i++){
      //         this.dataArr[i] = this.controls.slice((i*size), (i*size) + size);
      //     }
          
      //   })
      //   .catch(error => {
      //     console.log(error.response.data);
      //   });
    },
    createCard() {
      this.bottomValues = [];
      this.leftValues = [];
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
            item.forEach((i) => {
              value += i[this.firstGroup.value];
            });
            this.leftValues.push(value/this.sizeArr);
          })
          console.log("this.bottomValues", this.bottomValues);
          console.log("this.leftValues", this.leftValues);
          this.createChartData();
        })
        .catch(error => {
          console.log(error.response.data);
        });
    },
    changeControlsArr() {
      for (let i = 0; i <Math.ceil(this.controls.length/this.sizeArr); i++){
          this.dataArr[i] = this.controls.slice((i*this.sizeArr), (i*this.sizeArr) + this.sizeArr);
      }
    },
    createChartData() {
      this.chartData = [
        ['День - Зміна', this.firstGroup.name]
      ];
      for (let i = 0; i < this.bottomValues.length; i++) {
        this.chartData.push([this.bottomValues[i], this.leftValues[i]]);
      }
      this.showChart = true;
    }
  }
  }
</script>

<style lang="scss" scoped>
  .main {
    padding: 0 8px;
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
