export default {
    state: {
        validation_errors: null
    },
    mutations: {
        SET_VALIDATION_ERRORS (state, payload) {
            state.validation_errors = payload
        },
        CLEAR_VALIDATION_ERRORS (state) {
            state.validation_errors = null
        }
    },
    actions: {},
    getters: {
        validationErrors (state) {
            return state.validation_errors
        }
    }
}
