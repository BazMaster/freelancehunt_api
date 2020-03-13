// Css
import './scss/base.scss'

// Js
import './js/bootstrap.js'
import './js/js.js'

import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
import moment from 'moment'

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD.MM.YYYY hh:mm')
    }
});

window.axios = axios;

new Vue({
    el: '#app',
    render: h => h(App)
});
