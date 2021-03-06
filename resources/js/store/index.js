import Vue    from 'vue'
import Vuex   from 'vuex'

import common      from './modules/common'
import products    from './modules/products'
import cart        from './modules/cart'
import nova_poshta from './modules/nova_poshta'
import order       from './modules/order'
import validation_errors  from './modules/validation_errors'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        common,
        products,
        cart,
        nova_poshta,
        order,
        validation_errors
    }
})
