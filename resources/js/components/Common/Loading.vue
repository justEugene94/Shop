<template>
    <v-container v-if="loading">
        <v-layout row>
            <v-flex xs12 class="text-center pt-5">
                <v-progress-circular
                    :size="100"
                    :width="7"
                    color="deep-purple"
                    indeterminate
                ></v-progress-circular>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    name: 'Loading',
    computed: {
        loading () {
            return this.$store.getters.loading
        }
    }
}
</script>

<style scoped>

</style>
