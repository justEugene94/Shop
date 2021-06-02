<template>
    <v-layout v-if="notifications">
        <div
            v-for="(notification, i) in notifications"
            :key="i"
        >
            <v-snackbar
                :multi-line="true"
                :color="notification.severity"
                @input="close"
                :value="true"
            >
                {{ notification.text }}
                <template v-slot:action="{ attrs }">
                    <v-btn
                        dark
                        text
                        v-bind="attrs"
                        @click="close"
                    >
                        Close
                    </v-btn>
                </template>
            </v-snackbar>
        </div>
    </v-layout>
</template>

<script>
export default {
    name: 'Notifications',
    data() {
        return {
            timeout: 3000,
        }
    },
    computed: {
        notifications () {
            return this.$store.getters.notifications
        },
    },
    methods: {
        close () {
            this.$store.dispatch('clearNotifications').catch(() => {})
        }
    }
}
</script>

<style scoped>

</style>
