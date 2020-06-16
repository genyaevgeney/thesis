<template>
  <div class="Enterprise-shifts">
    <div class="Enterprise-shifts__info">
      <span v-if="!pageData.data.length" class="alert alert-warning" role="alert">
        На даний момент інформації немає.
      </span>
      <span v-else class="alert alert-info" role="alert">
        Дані було успішно отримано. Інформацію зображено нижче.
      </span>
    </div>
    <router-link class="Enterprise-shifts__shift hover-scale-shadow" v-for="(item, index) in pageData.data" :key="index" :to="`/shift/${item.id}`" >
      <span class="Enterprise-shifts__shift-id">#{{item.id}}</span>
      <span class="Enterprise-shifts__shift-line-id">лінія #{{item.line_id}}</span>
      <span class="Enterprise-shifts__shift-name">{{item.name}}</span>
      <span class="Enterprise-shifts__shift-time">{{item.time_begin}} - {{item.time_end}}</span>
      <span class="Enterprise-shifts__shift-date">{{item.created_at.split(' ')[0]}}</span>
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
        }
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
            `${process.env.VUE_APP_URL}/api/shifts/{shift}?page=${pageNum}`
          )
          .then(response => {
            this.pageData = response.data;
            response.data.pages = Math.ceil(
              this.pageData.total / this.pageData.per_page
            );
            console.log("Page data", this.pageData);
            this.checkPaginationRoute();
          })
          .catch(error => {
            console.log(error.response.data);
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
  .Enterprise-shifts {
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
      margin-bottom: 20px;
      display: flex;
      font-size: 16px;
      

      .alert {
        width:100%;
        margin: 0;
        font-family: "Sylfaen", sans-serif;
      }
    }

    &__shift {     
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

    &__shift-id {
      width: 20%;
      font-family: "BebasNeue-Bold", sans-serif; 
    }

    &__shift-line-id {
      width: 20%;
      font-family: "Sylfaen", sans-serif;
      
    }

    &__shift-name {
      width: 20%;
      font-family: "Sylfaen", sans-serif;
    }

    &__shift-time {
      width: 20%;
      font-family: 'BebasNeue-Book';
    }

    &__shift-date {
      width: 20%;
      font-family: 'BebasNeue-Book';
    }
  }
</style>
