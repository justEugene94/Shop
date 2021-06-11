<template>
    <v-list three-line>
        <h3>Shopping Cart</h3>
        <template v-for="(cartItem, index) in cart">

            <v-list-item
                :key="cartItem.id"
            >

                <v-list-item-avatar
                    height="120"
                    width="140"
                    rounded
                >
                    <v-img
                        src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                    ></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>
                        <router-link
                            :to="{name: 'productShow', params: {'productId': cartItem.product.id}}"
                        >
                            {{ cartItem.product.title }}
                        </router-link>
                    </v-list-item-title>
                    <v-list-item-subtitle v-html="'Quantity: ' + cartItem.qty"></v-list-item-subtitle>
                    <div>Price: <strong>{{ cartItem.product.price }}</strong></div>
                    <div>Total: <strong>{{ cartItem.product.price * cartItem.qty }}</strong></div>
                </v-list-item-content>

                <v-list-item-action>
                    <v-divider></v-divider>
                    <v-btn
                        dark
                        color="red"
                        depressed
                        @click="deleteItem(cartItem.product.id)"
                    >
                        <v-icon left>
                            mdi-delete-circle-outline
                        </v-icon>
                        Delete
                    </v-btn>
                </v-list-item-action>

            </v-list-item>

            <v-divider
                v-if="index + 1 < cart.length"
                :key="index"
            ></v-divider>

        </template>

        <v-fab-transition>
            <v-btn
                color="success"
                dark
                absolute
                bottom
                right
                :to="{name: 'checkout'}"
            >
                Checkout
            </v-btn>
        </v-fab-transition>
    </v-list>
</template>

<script>
export default {
    name: 'Cart',
    computed: {
        cart () {
            return this.$store.getters.cart
        }
    },
    methods: {
        deleteItem (productId) {
            this.$store.dispatch('deleteProductFromCart', productId).catch(() => {})
        }
    },
    created () {
        this.$store.dispatch('fetchCart').catch(() => {})
    }
}
</script>

<style scoped>
    .v-btn--example {
        bottom: 0;
        position: absolute;
        margin: 0 0 50px 16px;
    }
</style>
