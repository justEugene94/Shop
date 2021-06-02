export default {
    state: {
        loading: false,
        notifications: null,
        pagination: null
    },
    mutations: {
        setLoading (state, payload) {
            state.loading = payload
        },
        setPagination (state, payload) {
            state.pagination = payload
        },
        setNotifications (state, payload) {
            state.notifications = payload
        },
        clearNotifications (state) {
            state.notifications = null
        }
    },
    actions: {
        setLoading ({commit}, payload) {
            commit('setLoading', payload)
        },
        setPagination ({commit}, payload) {
            commit('setPagination', payload)
        },
        setNotifications ({commit}, payload) {
            commit('setNotifications', payload)
        },
        clearNotifications ({commit}) {
            commit('setNotifications')
        },
    },
    getters: {
        loading (state) {
            return state.loading
        },
        pagination (state) {
            return state.pagination
        },
        notifications (state) {
            return state.notifications
        }
    }
}
