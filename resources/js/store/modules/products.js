export default {
    state: {
        products: []
    },
    mutations: {
        loadProducts (state, payload) {
            state.products = payload
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
        }
    },
    getters: {
        products (state) {
            return state.products
        }
    }
}
