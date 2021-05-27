import Vue     from 'vue'
import App     from './App'
import vuetify from './plugins/vuetify'
import router from './router'

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    components: {App},
    template: '<App/>',
});
