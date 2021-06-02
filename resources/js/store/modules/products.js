export default {
    state: {
        products: [],
        product: null,
        promoProducts: []
    },
    mutations: {
        LOAD_PRODUCTS (state, payload) {
            state.products = payload
        },
        SET_PRODUCT (state, payload) {
            state.product = payload
        },
        SET_PROMO_PRODUCTS (state, payload) {
            state.promoProducts = payload
        }
    },
    actions: {
        async fetchProducts ({commit}, page) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            try {
                const products = await axios.get('/api/products/?page=' + page)

                commit('LOAD_PRODUCTS', products.data.result)

                if (typeof products.data.pagination !== 'undefined') {
                    commit('SET_PAGINATION', products.data.pagination.meta)
                }

                commit('SET_LOADING', false)
            } catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

                throw response
            }
        },
        async getProductById ({commit}, productId) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            try {
                const product = await axios.get('/api/products/' + productId)

                commit('SET_PRODUCT', product.data.result)
                commit('SET_LOADING', false)
            }
            catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

                throw response
            }
        },
        async getPromoProducts ({commit}) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            try {
                const promoProducts = await axios.get('/api/promo-products')

                commit('SET_PROMO_PRODUCTS', promoProducts.data.result)
                commit('SET_LOADING', false)
            }catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

                throw response
            }
        }
    },
    getters: {
        products (state) {
            return state.products
        },
        product(state) {
            return state.product
        },
        promoProducts (state) {
            return state.promoProducts
        }
    }
}
