<template>
  <div class="Line-shifts">
    <div class="Line-shifts__info">
      <span v-if="!pageData.length" class="alert alert-warning" role="alert">
        {{$route.params.name}} | На даний момент інформації немає.
      </span>
      <span v-else class="alert alert-info" role="alert">
        {{$route.params.name}} | Дані було успішно отримано. Інформацію зображено нижче.
      </span>
    </div>
    <a class="Line-shifts__shift hover-scale-shadow" v-for="(item, index) in pageData" :key="index" @click="clickShift(item.id, item.name)" >
      <span class="Line-shifts__shift-id">#{{item.id}}</span>
      <span class="Line-shifts__shift-name">{{item.name}}</span>
      <span class="Line-shifts__shift-time">{{item.time_begin}} - {{item.time_end}}</span>
      <span class="Line-shifts__shift-date">{{item.created_at.split(' ')[0]}}</span>
    </a>
    <PaginationMenu :backendData="pageData" />
    <modal name="shift-modal" class="site-modal">
      <router-link :to="`/${$route.params.name}/shift/${shiftId}/${shiftName}`" class="modal-btn">Отримати усі дані зміни</router-link>
      <router-link :to="`/${$route.params.name}/shift/${shiftId}/${shiftName}/days/page=1`" class="modal-btn">Отримати дані зміни за день</router-link>
    </modal>
  </div>
</template>

<script>
  import PaginationMenu from "@/components/base/PaginationMenu";
  import axios from "axios";

  export default {
    data() {
      return {
        pageData: [],
        shiftId: null,
        shiftName: null
      };
    },
    components: {
      PaginationMenu
    },
    mounted() {
      this.loadPageData(this.$route.params.id);
    },
    watch: {
      $route(to, from) {
        this.loadPageData(this.$route.params.id);
      }
    },
    methods: {
      clickShift(shiftId, shiftName) {
        this.shiftId = shiftId;
        this.shiftName = shiftName;
        this.$modal.show('shift-modal');
      },
      checkPaginationRoute() {
        if (
          (this.pageData.pages !== 0 &&
            this.$route.params.id > this.pageData.pages) ||
          isNaN(Number(this.$route.params.id))
        ) {
          this.$router.push(`/error`);
        }
      },
      loadPageData(id) {
        axios
          .get(
            `${process.env.VUE_APP_URL}/api/line/${id}/shifts`
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
  .Line-shifts {
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
      width: 10%;
      font-family: 'BebasNeue-Bold';
      
    }

    &__shift-time {
      width: 30%;
      font-family: 'BebasNeue-Book';
      
    }

    &__shift-name {
      width: 30%;
      font-family: "Sylfaen", sans-serif;
      
    }

    &__shift-date {
      width: 30%;
      font-family: 'BebasNeue-Book';
    }
  }
</style>
