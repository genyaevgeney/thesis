<template>
  <div class="Enterprise-lines">
    <div class="Enterprise-lines__info">
      <span v-if="!pageData.data.length" class="alert alert-warning" role="alert">
        На даний момент інформації немає.
      </span>
      <span v-else class="alert alert-info" role="alert">
        Дані було успішно отримано. Інформацію зображено нижче.
      </span>
    </div>
    <a class="Enterprise-lines__line hover-scale-shadow" v-for="(item, index) in pageData.data" :key="index" @click="clickLine(item.name, item.id)">
      <span class="Enterprise-lines__line-number">#{{item.id}}</span>
      <span class="Enterprise-lines__line-name">{{item.name}}</span>
      <span class="Enterprise-lines__line-date">{{item.created_at.split(' ')[0]}}</span>
    </a>
    <PaginationMenu :backendData="pageData" />
    <modal name="line-modal" class="site-modal">
      <router-link :to="`/line/${lineId}`" class="modal-btn">Отримати усі дані лінії</router-link>
      <router-link :to="`/line/${lineName}/${lineId}/shifts`" class="modal-btn">Отримати дані зміни лінії</router-link>
    </modal>
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
        lineName: null,
        lineId: null
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
      clickLine(lineName, lineId) {
        this.lineName = lineName;
        this.lineId = lineId;
        this.$modal.show('line-modal');
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
            `${process.env.VUE_APP_URL}/api/lines/{line}?page=${pageNum}`
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
  .Enterprise-lines {
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

    &__line {     
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

    &__line-number {
      width: 10%;
      font-family: 'BebasNeue-Bold';
      
    }

    &__line-name {
      width: 30%;
      font-family: "Sylfaen", sans-serif;
      
    }

    &__line-date {
      width: 60%;
      font-family: 'BebasNeue-Book';
    }
  }
</style>
