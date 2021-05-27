<template>
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
<!--                        <v-img-->
<!--                            :src="product.imageSrc"-->
<!--                            height="200px"-->
<!--                        ></v-img>-->

                        <v-card-title>
                            {{ product.title }}
                        </v-card-title>

                        <v-card-subtitle>
                            {{ product.price }}
                        </v-card-subtitle>

                        <v-card-actions>
                            <v-spacer></v-spacer>
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
        </v-container>
    </div>
    <div v-else>
        <v-container>
            <v-layout row>
                <v-flex xs12 class="text-center pt-5">
                    <v-progress-circular
                        :size="100"
                        :width="4"
                        color="purple"
                        indeterminate
                    ></v-progress-circular>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
export default {
    name: 'ProductList',
    computed: {
        products () {
            console.log(this.$store.getters.products)
            return this.$store.getters.products
        },
        loading () {
            console.log(this.$store.getters.loading)
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
