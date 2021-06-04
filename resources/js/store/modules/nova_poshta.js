export default {
    state: {
        cities: [],
        warehouses: []
    },
    mutations: {
        LOAD_CITIES (state, payload) {
            state.cities = payload
        },
        LOAD_WAREHOUSES (state, payload) {
            state.warehouses = payload
        }
    },
    actions: {
        async fetchCities ({commit}, citeName) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            try {
                const cities = await axios.get('/api/nova-poshta/cities', {
                    params: {
                        city: citeName
                    }
                })

                commit('LOAD_CITIES', cities.data.result)
                commit('SET_LOADING', false)
            }
            catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

                throw response
            }
        },
        async fetchWarehouses ({commit}, citeName) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)

            try {
                const warehouses = await axios.get('/api/nova-poshta/warehouses', {
                    params: {
                        city: citeName
                    }
                })

                commit('LOAD_WAREHOUSES', warehouses.data.result)
                commit('SET_LOADING', false)
            }
            catch (e) {
                const response = e.response

                commit('SET_NOTIFICATIONS', response.data.messages)
                commit('SET_LOADING', false)

                throw response
            }
        }
    },
    getters: {
        cities (state) {
            return state.cities
        },
        warehouses (state) {
            return state.warehouses
        }
    }
}
