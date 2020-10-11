import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import EventCalendar from './components/EventCalendar'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/calendar'
        },
        {
            path: '/calendar',
            component: EventCalendar
        }
    ]
});

export default router