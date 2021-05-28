export default {
    state: {
        loading: false,
        error: null,
        pagination: null
    },
    mutations: {
        setLoading (state, payload) {
            state.loading = payload
        },
        setError (state, payload) {
            state.error = payload
        },
        clearError (state) {
            state.error = null
        },
        setPagination (state, payload) {
            state.pagination = payload
        }
    },
    actions: {
        setLoading ({commit}, payload) {
            commit('setLoading', payload)
        },
        setError ({commit}, payload) {
            commit('setError', payload)
        },
        clearError ({commit}) {
            commit('clearError')
        },
        setPagination ({commit}, payload) {
            commit('setPagination', payload)
        }
    },
    getters: {
        loading (state) {
            return state.loading
        },
        error (state) {
            return state.error
        },
        pagination (state) {
            return state.pagination
        }
    }
}
