<template>
    <div>
        <div v-if="!loading">
            <v-container fluid>
                <v-layout row>
                    <v-flex xs12>
                        <v-carousel>
                            <v-carousel-item
                                v-for="(product, i) in promoProducts"
                                :key="i"
                                src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                            >
                                <div class="product-links">
                                    <v-btn
                                        class="warning"
                                        :to="{name: 'productShow', params: {'productId': product.id}}"
                                    >{{ product.title }}
                                    </v-btn>
                                    <app-add-to-cart-button></app-add-to-cart-button>
                                </div>
                            </v-carousel-item>
                        </v-carousel>
                    </v-flex>
                </v-layout>
            </v-container>
        </div>
        <app-loading></app-loading>
    </div>
</template>

<script>
export default {
    name: 'Home',
    computed: {
        loading () {
            return this.$store.getters.loading
        },
        promoProducts () {
            return this.$store.getters.promoProducts
        }
    },
    created () {
        this.$store.dispatch('getPromoProducts')
            .catch(() => {})
    }
}
</script>

<style scoped>
.product-links {
    position: absolute;
    bottom: 50px;
    left: 50%;
    background: rgba(0, 0, 0, .5);
    transform: translate(-50%, 0);
    padding: 5px 15px;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
}
</style>
