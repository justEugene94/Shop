import Vue    from 'vue'
import Vuex   from 'vuex'

import common from './modules/common'
import products from './modules/products'
import cart from './modules/cart'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        common,
        products,
        cart
    }
})
