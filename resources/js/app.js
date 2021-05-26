import Vue     from 'vue'
import App     from './App'
import vuetify from './plugins/vuetify'

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    vuetify,
    components: {App},
    template: '<App/>',
});
