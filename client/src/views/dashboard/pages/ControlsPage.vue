<template>
  <div class="Data-page">
    <tabs>
      <tab title="Заміри">
        <table>
         <tr class="Data-page__table-header">
           <th><span>День</span></th>
          <th><span>Зміна</span></th>
          <th><span>Марка</span></th>
          <th><span>Вологість</span></th>
          <th><span>Питома площа поверхні</span></th>
          <th><span>Йодне число</span></th>
          <th><span>Абсорбція масла</span></th>
          <th><span>Насипна щільність</span></th>
          <th><span>Розмір гранул</span></th>
          <th><span>Опір стиранню</span></th>
          <th><span>Температура на виході</span></th>
          <th><span>Дата</span></th>
         </tr>
         <tr v-for="(item, index) in controls.data" :key="index" class="Data-page__table-row">
          <td><span>{{item.enterprise_day_id}}</span></td>
          <td><span>{{item.shift_id}}</span></td>
          <td><span>{{item.mark}}</span></td>
          <td><span>{{item.humidity}}</span></td>
          <td><span>{{item.specific_surface_area}}</span></td>
          <td><span>{{item.iodine_number}}</span></td>
          <td><span>{{item.oil_absorption}}</span></td>
          <td><span>{{item.bulk_density}}</span></td>
          <td><span>{{item.granule_size}}</span></td>
          <td><span>{{item.abrasion_resistance}}</span></td>
          <td><span>{{item.drum_outlet_temperature}}</span></td>
          <td><span>{{item.created_at}}</span></td>
          </tr>
        </table>
        <PaginationMenu :backendData="controls" />
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
      controls: []
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
    checkPaginationRouteControls() {
      if (
        (this.controls.pages !== 0 &&
          this.$route.params.num > this.controls.pages) ||
        isNaN(Number(this.$route.params.num))
      ) {
        this.$router.push(`/error`);
      }
    },
    loadPageData(num) {
      axios
        .get(
          `${process.env.VUE_APP_URL}/api/controls/{control}?page=${num}`
        )
        .then(response => {
          this.controls = response.data;
          response.data.pages = Math.ceil(
            this.controls.total / this.controls.per_page
          );
          console.log("Controls", this.controls);
          this.checkPaginationRouteControls();
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
