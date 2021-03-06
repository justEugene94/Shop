<template>
    <v-app>
        <v-navigation-drawer
            permanent
            expand-on-hover
            clipped
            app
            dark
            color="deep-purple"
        >
            <v-list>
                <v-list-item
                    v-for="link in links"
                    :key="link.title"
                    :to="link.url"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>
                            {{ link.icon }}
                        </v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title v-text="link.title"></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            clipped-left
            dark
            color="deep-purple"
        >
            <v-toolbar-title>
                <router-link
                    :to="{name: 'home'}"
                    class="pointer"
                    custom v-slot="{ navigate }"
                >
                    <span
                        role="link"
                        @click="navigate"
                    >
                        Here can be the name of your store
                    </span>
                </router-link>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn to="/cart" plain>
                <h4>({{ productsCount }})</h4>
                <v-icon right>mdi-cart-outline</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <router-view/>
        </v-main>

        <app-notifications></app-notifications>
    </v-app>
</template>

<script>
import Notifications from './components/Common/Notifications'
import Vue           from 'vue'
import { uuid }      from 'vue-uuid'

export default {
    name: 'App',
    components: {
        appNotifications: Notifications
    },
    computed: {
        error () {
            return this.$store.getters.error
        },
        productsCount () {
            return this.$store.getters.cartCount
        },
        links () {
            return [
                {title: 'Home', icon: 'mdi-home-outline', url: '/'},
                {title: 'Products', icon: 'mdi-shopping-outline', url: '/products'},
                {title: 'About us', icon: 'mdi-information-outline', url: '/about'},
                {title: 'Contacts', icon: 'mdi-phone-outline', url: '/contacts'},
            ]
        }
    },
    created () {
        if (!Vue.$cookies.isKey('cartId')) {
            Vue.$cookies.set('cartId', uuid.v4(), 60 * 60 * 24)
        }
        this.$store.dispatch('getProductsCount').catch(() => {})
    }
}
</script>

<style>
.pointer {
    cursor: pointer;
}

h2 {
    margin: 5% auto;
}
</style>
