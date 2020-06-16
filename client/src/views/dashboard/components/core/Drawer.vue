<template>
  <v-navigation-drawer
    id="core-navigation-drawer"
    v-model="drawer"
    :dark="barColor !== 'rgba(228, 226, 226, 1), rgba(255, 255, 255, 0.7)'"
    :expand-on-hover="expandOnHover"
    :right="$vuetify.rtl"
    :src="barImage"
    mobile-break-point="960"
    app
    width="260"
    v-bind="$attrs"
  >
    <template v-slot:img="props">
      <v-img
        :gradient="`to bottom, ${barColor}`"
        v-bind="props"
      />
    </template>

    <v-divider class="mb-1" />

    <v-list
      dense
      nav
    >
      <v-list-item>
        <v-list-item-avatar
          class="align-self-center"
          color="white"
          contain
        >
          <img 
            style="height:30px; width:30px;" 
            src="@/assets/logo.png"
          >
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title
            class="display-1"
            v-text="profile.title"
          />
        </v-list-item-content>
      </v-list-item>
    </v-list>

    <v-divider class="mb-2" />

    <v-list
      expand
      nav
    >
      <!-- Style cascading bug  -->
      <!-- https://github.com/vuetifyjs/vuetify/pull/8574 -->
      <div />
      <div :class="{ 'block-event': loadData }" class="drawer__btn" @click='generateDay'>
        <div :class="{ 'show-load': loadData }" class="lds-ring"><div></div><div></div><div></div><div></div></div>
        <span>Згенерувати день</span>
      </div>
      <template v-for="(item, i) in computedItems">
        <base-item-group
          v-if="item.children"
          :key="`group-${i}`"
          :item="item"
        >
          <!--  -->
        </base-item-group>

        <base-item
          v-else
          :key="`item-${i}`"
          :item="item"
        />
      </template>

      <!-- Style cascading bug  -->
      <!-- https://github.com/vuetifyjs/vuetify/pull/8574 -->
      <div />
    </v-list>

    <template v-slot:append>
      <base-item
        :item="{
          title: $t('upgrade'),
          icon: 'mdi-package-up',
          to: '/upgrade',
        }"
      />
    </template>
  </v-navigation-drawer>
</template>

<script>
  import axios from "axios";
  // Utilities
  import {
    mapState,
  } from 'vuex'

  export default {
    name: 'DashboardCoreDrawer',

    props: {
      expandOnHover: {
        type: Boolean,
        default: false,
      },
    },

    data: () => ({
      loadData: false,
      items: [
        {
          icon: 'mdi-view-dashboard',
          title: 'Головна сторінка',
          to: '/',
        },
        {
          icon: 'mdi-account',
          title: 'Дні підприємства',
          to: '/days/page=1',
        },
        {
          title: 'Зміни підприємства',
          icon: 'mdi-format-font',
          to: '/shifts/page=1',
        },
        {
          title: 'Лінії підприємства',
          icon: 'mdi-clipboard-outline',
          to: '/lines/page=1',
        },
        {
          title: 'Дані сенсорів',
          icon: 'mdi-chart-bubble',
          to: '/sensors/page=1',
        },
        {
          title: 'Дані замірів',
          icon: 'mdi-map-marker',
          to: '/controls/page=1',
        },
        {
          title: 'notifications',
          icon: 'mdi-bell',
          to: '/components/notifications',
        },
      ],
    }),

    computed: {
      ...mapState(['barColor', 'barImage']),
      drawer: {
        get () {
          return this.$store.state.drawer
        },
        set (val) {
          this.$store.commit('SET_DRAWER', val)
        },
      },
      computedItems () {
        return this.items.map(this.mapItem)
      },
      profile () {
        return {
          avatar: true,
          title: 'Система моніторингу',
        }
      },
    },

    methods: {
      generateDay() {
        this.loadData = true;
        axios
          .get(
            `${process.env.VUE_APP_URL}/api/generate-day`
          )
          .then(response => {
            this.loadData = false;
          })
          .catch(error => {
            console.log(error.response.data);
          });
      },
      mapItem (item) {
        return {
          ...item,
          children: item.children ? item.children.map(this.mapItem) : undefined,
          title: this.$t(item.title),
        }
      },
    },
  }
</script>

<style lang="sass">
  @import '~vuetify/src/styles/tools/_rtl.sass'

  .drawer__btn 
    background-color: #4CAF50
    color:white
    font-family: "Roboto", sans-serif
    font-weight: 300
    font-size: 14px
    display: flex
    justify-content: center
    align-items: center
    cursor: pointer
    transition: opacity .3s ease
    padding: 12px 0
    margin-bottom: 16px

  .drawer__btn:hover
    opacity: .7

  #core-navigation-drawer
    .v-list-group__header.v-list-item--active:before
      opacity: .24

    .v-list-item
      &__icon--text,
      &__icon:first-child
        justify-content: center
        text-align: center
        width: 20px

        +ltr()
          margin-right: 24px
          margin-left: 12px !important

        +rtl()
          margin-left: 24px
          margin-right: 12px !important

    .v-list--dense
      .v-list-item
        &__icon--text,
        &__icon:first-child
          margin-top: 10px

    .v-list-group--sub-group
      .v-list-item
        +ltr()
          padding-left: 8px

        +rtl()
          padding-right: 8px

      .v-list-group__header
        +ltr()
          padding-right: 0

        +rtl()
          padding-right: 0

        .v-list-item__icon--text
          margin-top: 19px
          order: 0

        .v-list-group__header__prepend-icon
          order: 2

          +ltr()
            margin-right: 8px

          +rtl()
            margin-left: 8px
</style>
