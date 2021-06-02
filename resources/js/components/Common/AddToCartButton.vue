<template>
    <v-btn
        class="error"
        depressed
        @click="add"
    >
        Add to cart
    </v-btn>
</template>

<script>
export default {
    name: 'AddToCartButton',
    props: {
      productId: {
          type: Number,
          required: true
      }
    },
    methods: {
        add() {
            const payload = {
                productId: this.productId,
                qty: 1,
                rewrite: false
            }

            this.$store.dispatch('addProductInCart', payload)
        }
    }
}
</script>

<style scoped>

</style>
