<template>
    <v-list three-line>
        <template v-for="(cartItem, index) in cart">

            <v-list-item
                :key="cartItem.id"
            >
                <v-list-item-avatar
                    height="120"
                    width="140"
                    rounded
                >
                    <v-img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                    ></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title v-html="cartItem.product.title"></v-list-item-title>
                    <v-list-item-subtitle v-html="cartItem.product.description"></v-list-item-subtitle>
                </v-list-item-content>

            </v-list-item>

            <v-divider
                v-if="index + 1 < cart.length"
                :key="index"
            ></v-divider>

        </template>
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
    created () {
        this.$store.dispatch('fetchCart').catch(() => {})
    }
}
</script>

<style scoped>

</style>
