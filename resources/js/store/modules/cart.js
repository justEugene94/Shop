import { uuid } from 'vue-uuid';
import Vue from 'vue';

export default {
    state: {
        cart: [],
        cartCount: 0
    },
    mutations: {
        SET_CART (state, payload) {
            state.cart = payload
        },
        SET_CART_COUNT (state, payload) {
            state.cartCount = payload
        },
        CLEAR_CART (state) {
            state.cart = []
            state.cartCount = 0
        },
        REMOVE_PRODUCT_FROM_CART(state, productId) {
            const index = state.cart.map(item => item.product.id).indexOf(productId)
            state.cart.splice(index, 1)
        }
    },
    actions: {
        async fetchCart ({commit}) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            const cookieId = Vue.$cookies.get('cartId')

            try {
                const cart = await axios.get('/api/cart', {
                    params: {
                        cookie_id: cookieId
                    }
                })

                commit('SET_CART', cart.data.result)
                commit('SET_LOADING', false)
            } catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

                throw response
            }
        },
        async addProductInCart ({commit}, {productId, qty, rewrite}) {
            commit('CLEAR_NOTIFICATIONS')

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

                commit('SET_NOTIFICATIONS', response.data.messages)
            } catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)

                throw response
            }
        },
        async deleteProductFromCart ({commit, getters}, productId) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            const cookieId = Vue.$cookies.get('cartId')

            try {
                const response = await axios.delete('/api/cart/delete', {
                    data: {
                        cookie_id: cookieId,
                        product_id: productId
                    }
                })

                commit('SET_NOTIFICATIONS', response.data.messages)

                commit('REMOVE_PRODUCT_FROM_CART', productId)

                commit('SET_LOADING', false)
            } catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

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
