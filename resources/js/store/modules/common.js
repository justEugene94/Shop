export default {
    state: {
        loading: false,
        notifications: null,
        pagination: null
    },
    mutations: {
        SET_LOADING (state, payload) {
            state.loading = payload
        },
        SET_PAGINATION (state, payload) {
            state.pagination = payload
        },
        SET_NOTIFICATIONS (state, payload) {
            state.notifications = payload
        },
        CLEAR_NOTIFICATIONS (state) {
            state.notifications = null
        }
    },
    actions: {
        setLoading ({commit}, payload) {
            commit('SET_LOADING', payload)
        },
        setPagination ({commit}, payload) {
            commit('SET_PAGINATION', payload)
        },
        setNotifications ({commit}, payload) {
            commit('SET_NOTIFICATIONS', payload)
        },
        clearNotifications ({commit}) {
            commit('CLEAR_NOTIFICATIONS')
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
