import Vue        from 'vue'
import App        from './App'
import vuetify    from './plugins/vuetify'
import router     from './router'
import store      from './store'
import Pagination from './components/Common/Pagination'
import Loading    from './components/Common/Loading'

require('./bootstrap');

window.Vue = require('vue');

Vue.component('app-pagination', Pagination)
Vue.component('app-loading', Loading)

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {App},
    template: '<App/>',
});
