import '../../bootstrap';
import '../../axios';

import { createApp } from 'vue';
import Router from '../../routes.js'; 
import { createStore } from 'vuex';
import store from '../../store.js';

 
import App from './layout/App.vue';

const app = createApp(App);


import HeaderWebsite from './layout/Header.vue';
import FooterWebsite from './layout/Footer.vue';


app.component('headerWebsite', HeaderWebsite);
app.component('footerWebsite', FooterWebsite);


app.use(Router); 
app.use(store); 



app.mount('#app');


