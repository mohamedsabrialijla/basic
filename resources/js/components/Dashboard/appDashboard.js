import '../../bootstrap';
import '../../axios';

import { createApp } from 'vue';
import Router from '../../routes.js'; 
import { createStore } from 'vuex';
import store from '../../store.js';  
// import Select2 from 'vue3-select2-component';




import AppDashboard from './layout/AppDashboard.vue';

const dashboardApp = createApp(AppDashboard);

import HeaderDashboard from './layout/HeaderDashboard.vue';
import FooterDashboard from './layout/FooterDashboard.vue';


dashboardApp.component('HeaderDashboard', HeaderDashboard);
dashboardApp.component('FooterDashboard', FooterDashboard);

  
dashboardApp.use(Router); 
dashboardApp.use(store); 
// app.component('Select2', Select2)


dashboardApp.mount('#dashboard-app');

