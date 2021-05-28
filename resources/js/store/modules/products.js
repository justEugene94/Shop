export default {
    state: {
        products: [],
        product: null
    },
    mutations: {
        loadProducts (state, payload) {
            state.products = payload
        },
        setProduct (state, payload) {
            state.product = payload
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
                commit('setError', e.messages.error)
                commit('setLoading', false)

                throw e
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
                commit('setError', e.messages.error)
                commit('setLoading', false)

                throw e
            }
        }
    },
    getters: {
        products (state) {
            return state.products
        },
        product(state) {
            return state.product
        }
    }
}
