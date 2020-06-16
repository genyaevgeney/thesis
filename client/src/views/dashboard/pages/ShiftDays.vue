<template>
  <div class="Enterprise-days">
    <div class="Enterprise-days__info">
      <span v-if="!pageData.data.length" class="alert alert-warning" role="alert">
        {{$route.params.lineName}} - {{$route.params.shiftName}} | На даний момент інформації немає.
      </span>
      <span v-else class="alert alert-info" role="alert">
        {{$route.params.lineName}} - {{$route.params.shiftName}} | Дані було успішно отримано. Інформацію зображено нижче.
      </span>
    </div>
    <router-link class="Enterprise-days__day hover-scale-shadow" v-for="(item, index) in pageData.data" :key="index" :to="`/day/${item.id}/shift/${$route.params.shiftId}`" >
      <span class="Enterprise-days__day-number">День {{item.number}}</span>
      <span class="Enterprise-days__day-date">{{item.created_at.split(' ')[0]}}</span>
    </router-link>
    <PaginationMenu :backendData="pageData" />
  </div>
</template>

<script>
  import PaginationMenu from "@/components/base/PaginationMenu";
  import axios from "axios";

  export default {
    data() {
      return {
        pageData: {
          data: []
        },
        loadData: false
      };
    },
    components: {
      PaginationMenu
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
      generateDay() {
        this.loadData = true;
        axios
          .get(
            `${process.env.VUE_APP_URL}/api/generate-day`
          )
          .then(response => {
            this.loadPageData(this.$route.params.num);
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      checkPaginationRoute() {
        if (
          (this.pageData.pages !== 0 &&
            this.$route.params.num > this.pageData.pages) ||
          isNaN(Number(this.$route.params.num))
        ) {
          this.$router.push(`/error`);
        }
      },
      loadPageData(pageNum) {
        axios
          .get(
            `${process.env.VUE_APP_URL}/api/days/{day}?page=${pageNum}`
          )
          .then(response => {
            this.pageData = response.data;
            response.data.pages = Math.ceil(
              this.pageData.total / this.pageData.per_page
            );
            console.log("Page data", this.pageData);
            this.checkPaginationRoute();
            this.loadData = false;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .Enterprise-days {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    padding-bottom: 70px;

    & > *:not(:last-child) {
      width: 80%;
      display: flex;
    }

    &__info {
      justify-content: space-between;
      margin-bottom: 20px;
      display: flex;
      font-size: 16px;
      

      .alert {
        width: 100%;
        margin: 0;
        font-family: "Sylfaen", sans-serif;
      }
    }

    &__day {     
      background-color: white;
      color:black;
      text-decoration:none;

      &:not(:last-child) {
        margin-bottom: 20px;
      }

      & > * {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        padding: 15px 0;
      }
    }

    &__day-number {
      width: 20%;
      font-family: 'BebasNeue-Bold';
      
    }

    &__day-date {
      width: 80%;
      font-family: 'BebasNeue-Book';
    }
  }
</style>
