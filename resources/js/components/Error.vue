<template>
    <v-layout v-if="error">
        <v-snackbar
            :multi-line="true"
            color="error"
            @input="closeError"
            :value="true"
            :timeout="3000"
        >
            {{ error }}
            <template v-slot:action="{ attrs }">
                <v-btn
                    dark
                    text
                    v-bind="attrs"
                    @click="closeError"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </v-layout>
</template>

<script>
export default {
    name: 'Error',
    computed: {
        error () {
            return this.$store.getters.error
        },
    },
    methods: {
        closeError () {
            this.$store.dispatch('clearError')
        }
    }
}
</script>

<style scoped>

</style>
