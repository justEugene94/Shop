import { uuid } from 'vue-uuid';
import Vue from 'vue';

export default {
    state: {
        cart: [],
        cartCount: 0
    },
    mutations: {
        setCart (state, payload) {
            state.cart = payload
        },
        setCartCount (state, payload) {
            state.cartCount = payload
        },
        clearCart (state) {
            state.cart = []
            state.cartCount = 0
        }
    },
    actions: {
        async fetchCart ({commit}) {
            commit('clearNotifications')
            commit('setLoading', true)

            const cookieId = Vue.$cookies.get('cartId')

            try {
                const cart = await axios.get('/api/cart', {
                    params: {
                        cookie_id: cookieId
                    }
                })

                commit('setCart', cart.data.result)
                commit('setLoading', false)
            } catch (e) {
                const response = e.response

                commit('setNotifications', response.data.messages)
                commit('setLoading', false)

                throw response
            }
        },
        async addProductInCart ({commit}, {productId, qty, rewrite}) {
            commit('clearNotifications')

            if (!Vue.$cookies.isKey('cartId')) {
                Vue.$cookies.set('cartId', uuid.v4(), 60*60*24)
            }

            const cookieId = Vue.$cookies.get('cartId')


            try {
                const response = await axios.post('/api/cart/add', {
                    cookie_id: cookieId,
                    product_id: productId,
                    qty,
                    rewrite
                })

                commit('setNotifications', response.data.messages)
            } catch (e) {
                const response = e.response

                commit('setNotifications', response.data.messages)

                throw response
            }
        }
    },
    getters: {
        cart (state) {
            return state.cart
        },
        cartCount (state) {
            return state.cartCount
        }
    }
}
