<template>
    <div>
        <app-loading></app-loading>
        <div v-if="!loading">
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex
                        xs12
                        sm6
                        md4
                        v-for="product in products"
                        :key="product.id"
                    >
                        <v-card
                            class="mx-auto"
                            max-width="344"
                        >
                            <v-img
                                src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                                height="200px"
                            ></v-img>

                            <v-card-title>
                                {{ product.title }}
                            </v-card-title>

                            <v-card-text>
                                Price: <strong>{{ product.price }}</strong>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="error"
                                    depressed
                                >
                                    Buy
                                </v-btn>
                                <v-btn
                                    text
                                    :to="{name: 'productShow', params: {'productId': product.id}}"
                                >
                                    Open
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
                <app-pagination :fetchMethod="'fetchProducts'"></app-pagination>
            </v-container>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductList',
    computed: {
        products () {
            return this.$store.getters.products
        },
        loading () {
            return this.$store.getters.loading
        }
    },
    created () {
        this.$store.dispatch('fetchProducts')
            .catch(() => {})
    }
}
</script>

<style scoped>

</style>
