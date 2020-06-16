<template>
  <div class="Data-page">
    <tabs>
      <tab title="Сенсори">
        <table>
         <tr class="Data-page__table-header">
          <th><span>День</span></th>
          <th><span>Зміна</span></th>
          <th><span>Вологість</span></th>
          <th><span>Температура</span></th>
          <th><span>Оберти барабану</span></th>
          <th><span>Оброблено вуглецю</span></th>
          <th><span>Пальне 1 зони</span></th>
          <th><span>Пальне 2 зони</span></th>
          <th><span>Газ 3 зони</span></th>
          <th><span>Газ аксіального пальника</span></th>
          <th><span>Енергія приводу</span></th>
          <th><span>Енергія 1 компресору</span></th>
          <th><span>Енергія 2 компресору</span></th>
          <th><span>Енергія 3 компресору</span></th>
          <th><span>Додаткова енергія</span></th>
          <th><span>Воднево-міласовий розчин</span></th>
          <th><span>Дата</span></th>
         </tr>
         <tr v-for="(item, index) in sensors.data" :key="index" class="Data-page__table-row">
          <td><span>{{item.enterprise_day_id}}</span></td>
          <td><span>{{item.shift_id}}</span></td>
          <td><span>{{item.humidity}}</span></td>
          <td><span>{{item.temperature}}</span></td>
          <td><span>{{item.drum_speed}}</span></td>
          <td><span>{{item.processed_carbon}}</span></td>
          <td><span>{{item.first_zone_fuel}}</span></td>
          <td><span>{{item.second_zone_fuel}}</span></td>
          <td><span>{{item.third_zone_gas}}</span></td>
          <td><span>{{item.burner_gas}}</span></td>
          <td><span>{{item.drum_drive_energy}}</span></td>
          <td><span>{{item.first_compressor_energy}}</span></td>
          <td><span>{{item.second_compressor_energy}}</span></td>
          <td><span>{{item.third_compressor_energy}}</span></td>
          <td><span>{{item.additional_functions_energy}}</span></td>
          <td><span>{{item.water_solution}}</span></td>
          <td><span>{{item.created_at}}</span></td>
          </tr>
        </table>
        <PaginationMenu :backendData="sensors" />
      </tab>
    </tabs>
  </div>
</template>

<script>
import { Tabs, Tab } from 'vue-slim-tabs'
import 'vue-slim-tabs/themes/default.css'
import PaginationMenu from "@/components/base/PaginationMenu";
import axios from "axios";

export default {
  data() {
    return {
      sensors: [],
    };
  },
  components: {
    Tabs, Tab, PaginationMenu
  },
  mounted() {
    this.loadPageData(this.$route.params.num);
  },
  watch: {
    $route(to, from) {
      this.loadPageData(this.$route.params.num);
    }
  },
  methods: {
    checkPaginationRouteSensors() {
      if (
        (this.sensors.pages !== 0 &&
          this.$route.params.num > this.sensors.pages) ||
        isNaN(Number(this.$route.params.num))
      ) {
        this.$router.push(`/error`);
      }
    },
    loadPageData(num) {
      axios
        .get(
          `${process.env.VUE_APP_URL}/api/sensors/{sensor}?page=${num}`
        )
        .then(response => {
          this.sensors = response.data;
          response.data.pages = Math.ceil(
            this.sensors.total / this.sensors.per_page
          );
          console.log("Sensors", this.sensors);
          this.checkPaginationRouteSensors();
        })
        .catch(error => {
          console.log(error.response.data);
        });
    }
  }
}
</script>

<style lang="scss">
  .Dashboard__pagination {
    background-color: #181E23;
    padding:10px 0 !important;
    position:relative !important;
    .pagination {
      margin: 0;
    }
    li{
      &.active {
        color:silver;
      }
      &.disabled {
        color:#4caf50;
      }
    }
  }
  .Data-page {

    &__table-row {
      &:nth-child(odd) {
        background-color: #2F2F30;
      }
    }

    &__table-header {
      background-color: #181E23;
    }

    table {
      display: block;
      width: 100%;
      overflow-x: scroll;
      height:calc(100vh - 116px);
      white-space: nowrap;
      background-color: #1D2529;
      border-top: 6px solid #4CAF50;
      color:silver;
      
      &::-webkit-scrollbar-track {
      	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
        border-radius: 10px;
      }

      &::-webkit-scrollbar {
      	width: 18px;
        height:18px;
      }

      &::-webkit-scrollbar-thumb {
      	border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
      }

      th {
        font-family: "Sylfaen", sans-serif;
        font-size:15px;
        letter-spacing: 0.3px;

        &:last-child {
          width: 146px;
          display: inline-block;
        }
      }

      td {
        font-family: "BebasNeue-Book", sans-serif;
        font-size:17px;
        letter-spacing: 0.5px;
      }

      th, td {
        &:not(:last-child) {
          border-right:1px solid silver;
        }
        span {
          display: inline-flex;
          justify-content: center;
          align-items: center;
          width: 100%;
        }  
      }

      th {
        span {
          padding: 10px 15px;
        }  
      }

      td {
        span {
          padding: 8px 0;
        }  
      }

    }
  }

</style>
