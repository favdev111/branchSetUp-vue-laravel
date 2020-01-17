window._ = require('lodash');
import Vue from 'vue';
import Vuelidate from 'vuelidate';
import * as VueGoogleMaps from 'vue2-google-maps'
import Geocoder from "@pderas/vue2-geocoder";
import vSelect from 'vue-select'
import Toasted from 'vue-toasted';
import VueRouter from 'vue-router';
import PrettyCheckbox from 'pretty-checkbox-vue';
import 'bootstrap/js/dist/dropdown';
import { VBTooltip } from 'bootstrap-vue'
import "bootstrap-vue/dist/bootstrap-vue.css";

window._ = require('lodash');
try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.request.use(
    function(config) {
        config.url = `ajax${config.url}`;
        return config;
    },
    function(error) {
        return Promise.reject(error);
    }
);

window.axios.interceptors.response.use(
    function(response) {
        return response;
    },
    function(error) {
        Vue.toasted.error(error.response.data.message, {
            className: 'bg-red'
        });
        return Promise.reject(error);
    }
);


Vue.component('v-select', vSelect);
Vue.directive('b-tooltip', VBTooltip);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

Vue.use(Toasted, {
    position: 'bottom-center',
    singleton: false,
    duration: 1500,
    theme: 'bubble',
    iconPack: 'fontawesome',
    className: 'bg-primary',
});
Vue.use(VueRouter);
Vue.use(PrettyCheckbox);
Vue.use(Geocoder, {
    defaultCountryCode: 'US',
    defaultLanguage:    null,
    defaultMode:        'address',
    googleMapsApiKey:   'AIzaSyD2my6bwPBehUVpmOYxdFfwYHyRobrRok8'
});
//
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyD2my6bwPBehUVpmOYxdFfwYHyRobrRok8',
        libraries: 'places'
    },
});

Vue.use(Vuelidate);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => {
    let name = key.split('/').pop().split('.')[0].replace(/([a-z])([A-Z])/g, "$1-$2")
        .replace(/\s+/g, '-')
        .toLowerCase();
    Vue.component(name, files(key).default)
});

import Employees from './components/employees/EmployeesList';
import EmployeeShow from './components/employees/EmployeesShow';
import Technicians from './components/technicians/TechniciansList';
import WorkOrder from './components/workorder/WorkOrder.vue';
import WorkOrderTest from './components/workorder/WorkOrderTest.vue';


// import store from './store';
const router = new VueRouter({
    linkActiveClass: 'active',
    mode: 'history',
    routes: [
        {path: `/employees`, component: Employees},
        {path: `/employees/:id`, component: EmployeeShow},
        {
            name: 'workorder_create',
            path: '/workorder_create',
            component: WorkOrder
        },
        {
            name: 'workorder_create_test',
            path: '/workorder_create_test',
            component: WorkOrderTest
        }
    ]
});

const app = new Vue({
    el: '#app',
    router,
});
