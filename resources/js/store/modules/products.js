export default {
    state: {
        products: [],
        product: null,
        promoProducts: []
    },
    mutations: {
        loadProducts (state, payload) {
            state.products = payload
        },
        setProduct (state, payload) {
            state.product = payload
        },
        setPromoProducts (state, payload) {
            state.promoProducts = payload
        }
    },
    actions: {
        async fetchProducts ({commit}, page) {
            commit('clearError')
            commit('setLoading', true)

            try {
                const products = await axios.get('/api/products/?page=' + page)

                commit('loadProducts', products.data.result)

                if (typeof products.data.pagination !== 'undefined') {
                    commit('setPagination', products.data.pagination.meta)
                }

                commit('setLoading', false)
            } catch (e) {
                const response = e.response

                commit('setError', response.data.messages[0].text)
                commit('setLoading', false)

                throw response
            }
        },
        async getProductById ({commit}, productId) {
            commit('clearError')
            commit('setLoading', true)

            try {
                const product = await axios.get('/api/products/' + productId)

                commit('setProduct', product.data.result)
                commit('setLoading', false)
            }
            catch (e) {
                const response = e.response

                commit('setError', response.data.messages[0].text)
                commit('setLoading', false)

                throw response
            }
        },
        async getPromoProducts ({commit}) {
            commit('clearError')
            commit('setLoading', true)

            try {
                const promoProducts = await axios.get('/api/promo-products')

                commit('setPromoProducts', promoProducts.data.result)
                commit('setLoading', false)
            }catch (e) {
                const response = e.response

                commit('setError', response.data.messages[0].text)
                commit('setLoading', false)

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
