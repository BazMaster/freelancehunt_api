// Css
import './scss/base.scss'

// Js
import './js/bootstrap.js'
import './js/js.js'

import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
// import VueGoogleCharts from 'vue-google-charts'
// Vue.use(VueGoogleCharts);

window.axios = axios;

new Vue({
    el: '#app',
    render: h => h(App)
});
