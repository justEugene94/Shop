import Vue from 'vue'

export default {
    state: {
        order: null
    },
    mutations: {
        SET_ORDER (state, payload) {
            state.order = payload
        }
    },
    actions: {
        async createOrder ({commit}, {firstName, lastName, email, phoneNumber, city, warehouse}) {
            commit('CLEAR_NOTIFICATIONS')
            commit('SET_LOADING', true)
            commit('CLEAR_VALIDATION_ERRORS')

            const cookieId = Vue.$cookies.get('cartId')

            try {
                const order = await axios.post('/api/orders', {
                    cookie_id: cookieId,
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    mobile_phone: phoneNumber,
                    city: city,
                    np_json: JSON.stringify(warehouse),
                })

                commit('SET_ORDER', order.data.result)
                commit('SET_LOADING', false)
            } catch (e) {
                commit('SET_NOTIFICATIONS', e.response.data.messages)

                if (e.response.data.validation) {
                    commit('SET_VALIDATION_ERRORS', e.response.data.validation)
                }

                commit('SET_LOADING', false)

                throw e
            }
        }
    },
    getters: {
        order (state) {
            return state.order
        }
    }
}
