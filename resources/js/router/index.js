import Vue         from 'vue'
import Router      from 'vue-router'

import Home        from '../components/Home'
import ProductList from '../components/Products/ProductList'
import ProductShow from '../components/Products/ProductShow'
import About       from '../components/About'
import Contacts    from '../components/Contacts'
import Cart        from '../components/Cart'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/products',
            name: 'productList',
            component: ProductList
        },
        {
            path: '/products/:productId',
            name: 'productShow',
            props:true,
            component: ProductShow
        },
        {
            path: '/about',
            name: 'about',
            component: About
        },
        {
            path: '/contacts',
            name: 'contacts',
            component: Contacts
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart
        }
    ],
    mode: 'history'
})
