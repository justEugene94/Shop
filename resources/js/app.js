import Vue        from 'vue'
import App        from './App'
import vuetify    from './plugins/vuetify'
import router     from './router'
import store      from './store'
import Pagination from './components/Common/Pagination'
import Loading    from './components/Common/Loading'
import AddToCartButton  from './components/Common/AddToCartButton'

require('./bootstrap');

window.Vue = require('vue');

Vue.component('app-pagination', Pagination)
Vue.component('app-loading', Loading)
Vue.component('app-add-to-cart-button', AddToCartButton)

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components: {App},
    template: '<App/>',
});
