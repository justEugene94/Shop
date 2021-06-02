<template>
    <v-container>
        <v-layout row>
            <v-flex xs12>
                <v-card
                    class="mx-auto my-12"
                    v-if="!loading"
                >
                    <v-img
                        src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                        height="500px"
                    >
                    </v-img>
                    <v-card-title class="headline mb-1">
                        {{ product.title }}
                    </v-card-title>
                    <v-card-subtitle>
                        Price: <strong>{{ product.price }}</strong>
                    </v-card-subtitle>
                    <v-card-text>
                        {{ product.description }}
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <app-add-to-cart-button :productId="product.id"></app-add-to-cart-button>
                    </v-card-actions>
                </v-card>
                <app-loading></app-loading>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    name: 'ProductShow',
    props: {
        productId: {
            type: String|Number,
            required: true
        }
    }
    ,
    computed: {
        loading () {
            return this.$store.getters.loading
        },
        product () {
            return this.$store.getters.product
        }
    },
    created () {
        this.$store.dispatch('getProductById', parseInt(this.productId))
            .catch(() => {})
    }
}
</script>

<style scoped>

</style>
