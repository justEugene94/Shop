import Vue        from 'vue'
import VueCookies from 'vue-cookies'

import App        from './App'
import vuetify    from './plugins/vuetify'
import router     from './router'
import store      from './store'

import PaginationComponent from './components/Common/Pagination'
import LoadingComponent    from './components/Common/Loading'
import AddToCartButtonComponent  from './components/Common/AddToCartButton'

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueCookies)

Vue.component('app-pagination', PaginationComponent)
Vue.component('app-loading', LoadingComponent)
Vue.component('app-add-to-cart-button', AddToCartButtonComponent)

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {App},
    template: '<App/>',
});
