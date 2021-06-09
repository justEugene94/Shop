<template>
    <v-form
        v-model="valid"
        ref="form"
        validation
    >
        <h2>Checkout</h2>
        <v-container>
            <v-row>
                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="firstName"
                        :rules="nameRules"
                        :counter="10"
                        label="First name"
                        :error-messages="validationErrors && validationErrors['first_name']"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="lastName"
                        :rules="nameRules"
                        :counter="10"
                        label="Last name"
                        :error-messages="validationErrors && validationErrors['last_name']"
                        required
                    ></v-text-field>
                </v-col>

                <v-divider></v-divider>
            </v-row>

            <v-row>
                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="email"
                        :rules="emailRules"
                        label="E-mail"
                        :error-messages="validationErrors && validationErrors['email']"
                        required
                    ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="6"
                >
                    <v-text-field
                        v-model="phone"
                        :rules="phoneRules"
                        label="Phone Number"
                        :counter="12"
                        :error-messages="validationErrors && validationErrors['phone_number']"
                        required
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <h4 class="text-center">Pickup from Nova Poshta:</h4>
            <v-row>
                <v-col
                    cols="12"
                    md="6"
                >
                    <label>City:</label>
                    <v-select
                        v-model="city"
                        :options="cities"
                        label="DescriptionRu"
                        @search="setSelectedCity"
                        @input="fetchWarehouses"
                    >
                        <template slot="no-options">
                            type to search your city...
                        </template>
                    </v-select>
                    <div v-if="validationErrors && validationErrors['city']" class="invalid-feedback">
                        {{ validationErrors['city'][0] }}
                    </div>
                </v-col>
                <v-col
                    cols="12"
                    md="6"
                >
                    <label>Warehouse:</label>
                    <v-select
                        v-model="warehouse"
                        :options="warehouses"
                        label="DescriptionRu"
                        :disabled="loading"
                    >
                        <template slot="no-options">
                            type to search your warehouse...
                        </template>
                    </v-select>
                    <div v-if="validationErrors && validationErrors['np_json']" class="invalid-feedback">
                        {{ validationErrors['np_json'][0] }}
                    </div>
                </v-col>
            </v-row>
            <v-layout row>
                <v-flex xs12>
                    <v-spacer></v-spacer>
                    <v-btn
                        :disabled="!valid || loading"
                        class="success"
                        @click="createOrder"
                        :loading="loading"
                    >
                        Continue to pay
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-container>
    </v-form>
</template>

<script>
import vSelect from "vue-select"
import "vue-select/dist/vue-select.css";

export default {
    name: 'Checkout',
    data: () => ({
        valid: false,
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        city: '',
        warehouse: '',
        nameRules: [
            v => !!v || 'Name is required',
            v => v.length <= 10 || 'Name must be less than 10 characters',
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        phoneRules: [
            v => !!v || 'Phone Number is required',
            v => /(38)[0-9]{10}/.test(v) || 'Phone Number must be valid',
            v => v.length <= 12 || 'Phone Number must be less than 10 characters',
        ],
    }),
    computed: {
        loading () {
          return this.$store.getters.loading
        },
        cities () {
            return this.$store.getters.cities
        },
        warehouses () {
            return this.$store.getters.warehouses
        },
        validationErrors () {
            console.log(this.$store.getters.validationErrors)
            return this.$store.getters.validationErrors
        }
    },
    components: {
        vSelect,
    },
    methods: {
        setSelectedCity (search, loading) {
            if (search.length) {
                loading(true)
                this.$store.dispatch('fetchCities', search).catch(() => {})
            }
            loading(false)
        },
        fetchWarehouses (city) {
            this.warehouse = ''
            this.$store.dispatch('fetchWarehouses', city.DescriptionRu).catch(() => {})
        },
        createOrder () {
            if (this.$refs.form.validate()) {

                const order = {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    email: this.email,
                    phoneNumber: this.phone,
                    city: this.city.DescriptionRu,
                    warehouse: this.warehouse

                }

                this.$store.dispatch('createOrder', order)
                    .then(() => {
                        this.$router.push('/payment')
                    })
                    .catch(() => {})
            }
        }
    }
}
</script>

<style scoped>
    .invalid-feedback {
        display: block;
    }
</style>
