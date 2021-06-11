<template>
    <div>
        <h2 class="text-center">Payment time!</h2>

        <stripe-element-card
            ref="elementRef"
            :pk="this.publishableKey"
            @token="tokenCreated"
        />
        <v-btn
            @click="submit"
            :loading="loading"
            color="success"
        >
            Pay
        </v-btn>
    </div>
</template>

<script>
import { StripeElementCard } from '@vue-stripe/vue-stripe';

export default {
    name: 'Payment',
    components: {
        StripeElementCard,
    },
    data () {
        this.publishableKey = process.env.MIX_STRIPE_KEY
        return {
            token: null,
        };
    },
    computed: {
        loading () {
            return this.$store.getters.loading
        },
        order () {
            return this.$store.getters.order
        }
    },
    methods: {
        submit () {
            this.$refs.elementRef.submit();
        },
        tokenCreated (token) {
            this.$store.dispatch('payOrder', {order: this.order, token: token})
                .then(() => this.$router.push('/'))
                .catch(() => {})
        },
    }
}
</script>

<style scoped>

</style>
