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
        async fetchProducts ({commit}) {
            commit('clearError')
            commit('setLoading', true)

            try {
                const products = await axios.get('/api/products/')

                //todo: Removed Test and added pagination
                console.log(products.data.result)
                commit('loadProducts', products.data.result)

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
