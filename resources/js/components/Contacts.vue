<template>
    <v-container fluid>
        <v-row dense>
            <v-col
                v-for="(card, i) in cards"
                :key="i"
                cols="6"
            >
                <v-card>
                    <v-img
                        :src="card.src"
                        height="200px"
                    >
                    </v-img>

                    <v-card-actions>
                        <v-btn
                            elevation="2"
                            block
                            dark
                            color="deep-purple"
                            :href="card.link"
                        >
                            {{ card.text }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'Contacts',
    data: () => ({
        cards: [
            {
                src: 'https://www.securitylab.ru/upload/iblock/4ef/4ef0adc04b985bbac6fafc52ea457ba4.png',
                link: 'https://github.com/justEugene94',
                text: 'Link to github'
            },
            {
                src: 'https://miro.medium.com/max/3840/1*8ZsXWqdo9OwAfwychr3zEw.png',
                link: 'https://t.me/justEugene94',
                text: 'Link to telegram'
            }
        ],
    }),
}
</script>

<style scoped>

</style>
