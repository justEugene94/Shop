<template>
    <div class="text-center" v-if="pagination">
        <v-pagination
            v-model="pagination.current_page"
            :length="pagination.last_page"
            :total-visible="7"
            @input="next"
            circle
            color="deep-purple"
        ></v-pagination>
    </div>
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        fetchMethod: {
            type: String,
            required: true
        },
    },
    computed: {
        pagination() {
            return this.$store.getters.pagination
        }
    },
    methods:{
        next (page) {
            this.$store.dispatch(this.fetchMethod, page)
        }
    }
}
</script>

<style scoped>

</style>
