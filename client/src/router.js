import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      component: () => import('@/views/dashboard/Index'),
      children: [
        // Dashboard
        {
          name: 'Головна сторінка',
          path: '',
          component: () => import('@/views/dashboard/Dashboard'),
        },
        {
          name: `Список днів підприємства`,
          path: 'days/page=:num',
          component: () => import('@/views/dashboard/pages/EnterpriseDays'),
        },
        {
          name: `Дані замірів та сенсорів за день`,
          path: 'day/:num',
          component: () => import('@/views/dashboard/pages/EnterpriseDay'),
        },
        {
          name: 'Список ліній підприємства',
          path: 'lines/page=:num',
          component: () => import('@/views/dashboard/pages/EnterpriseLines'),
        },
        {
          name: 'Список змін лінії',
          path: 'line/:name/:id/shifts',
          component: () => import('@/views/dashboard/pages/LineShifts'),
        },
        {
          name: 'Усі дані зміни',
          path: ':lineName/shift/:shiftId/:shiftName',
          component: () => import('@/views/dashboard/pages/ShiftPage'),
        },
        {
          name: 'Усі дні зміни',
          path: ':lineName/shift/:shiftId/:shiftName/days/page=:num',
          component: () => import('@/views/dashboard/pages/ShiftDays'),
        },
        {
          name: 'Усі дані зміни за день',
          path: 'day/:dayId/shift/:shiftId',
          component: () => import('@/views/dashboard/pages/ShiftDayPage'),
        },
        {
          name: 'Список змін підприємства',
          path: 'shifts/page=:num',
          component: () => import('@/views/dashboard/pages/EnterpriseShifts'),
        },
        {
          name: 'Усі дані лінії',
          path: 'line/:lineId',
          component: () => import('@/views/dashboard/pages/LineData'),
        },
        {
          name: 'Усі дані зміни',
          path: 'shift/:shiftId',
          component: () => import('@/views/dashboard/pages/ShiftData'),
        },
        {
          name: 'Усі дані сенсорів',
          path: 'sensors/page=:num',
          component: () => import('@/views/dashboard/pages/SensorsPage'),
        },
        {
          name: 'Усі дані замірів',
          path: 'controls/page=:num',
          component: () => import('@/views/dashboard/pages/ControlsPage'),
        },
        {
          name: 'Карти Шухарта середнього та розмахів для параметрів технічного вуглецю',
          path: '/shuhart-cards',
          component: () => import('@/views/dashboard/pages/HumidityCard'),
        },
      ],
    },
  ],
})
