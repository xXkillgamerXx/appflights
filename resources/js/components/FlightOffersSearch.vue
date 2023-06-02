<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2 d-flex">
                        <div class="form-group">
                            <select v-model="options" class="form-control" id="exampleFormControlSelect1">
                                <option value="0">Ida y vuelta</option>
                                <option value="1">Solo ida</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" min="0" max="10" class="form-control" id="adults" v-model="adults" />
                        </div>
                        <input type="text"  class="form-control" id="currency" v-model="currencyCode" />
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="adults" class="mb-2">¿Desde dónde?</label>
                                        <input class="form-control" type="text" id="origin" v-model="originLocationCode" />
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="adults" class="mb-2">¿A dónde quieres ir?</label>
                                        <input class="form-control" type="text" id="destination" v-model="destinationLocationCode" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group" :class="options == 0 ? ' col-6' : 'col-12'">
                                        <label for="adults" class="mb-2">{{ options == 0 ? 'Ida' : 'Solo ida'}}</label>
                                        <input type="date" class="form-control" id="departure" v-model="departureDate" />
                                    </div>
                                    <div class="form-group col-6" v-if="options == 0">
                                        <label for="adults" class="mb-2">Vuelta</label>
                                        <input type="date" class="form-control" id="return" v-model="returnDate" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mt-2">
                        <button @click="login" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="max">Máximo:</label>
            <input type="number" class="form-control" id="max" v-model="max" />
        </div>
        <table  class="table" v-if="flightOffers.data && flightOffers.data.length > 0">
            <thead>
            <tr>
                <th>Aerolínea</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha de Salida</th>
                <th>Fecha de Regreso</th>
                <th>Precio Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="offer in flightOffers.data" :key="offer.id">
                <td>{{ offer.validatingAirlineCodes[0] }}</td>
                <td>{{ getCityName(offer.itineraries[0].segments[0].departure.iataCode) }}</td>
                <td>{{ getCityName(offer.itineraries[0].segments[0].arrival.iataCode) }}</td>
                <td>{{ formatDate(offer.itineraries[0].segments[0].departure.at) }}</td>
                <td>{{ formatDate(offer.itineraries[1].segments[0].departure.at) }}</td>
                <td>{{ offer.price.total }}</td>
            </tr>
            </tbody>
        </table>
        <div v-else>
            No se encontraron resultados de vuelos.
        </div>

        <div v-if="error">{{ error }}</div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            options : 0,
            accessToken: '',
            originLocationCode: 'SDQ',
            destinationLocationCode: 'NYC',
            departureDate: '2023-07-07',
            returnDate: '2023-07-11',
            adults: 2,
            max: 10,
            currencyCode: 'DOP',
            flightOffers: {},
            error: null,
            locations: {},
        };
    },
    mounted() {
        // Realizar el inicio de sesión al cargar el componente
        this.login();
    },
    methods: {
        login() {
            this.flightOffers = {};
            const clientId = 'FGnAfp2G2IAnhr1KHtY10GSzOQusd9VZ';
            const clientSecret = 'MOF6wQxBlkXHWxob';
            const url = 'https://test.api.amadeus.com/v1/security/oauth2/token';

            const params = new URLSearchParams();
            params.append('grant_type', 'client_credentials');
            params.append('client_id', clientId);
            params.append('client_secret', clientSecret);

            axios.post(url, params)
                .then(response => {
                    this.accessToken = response.data.access_token;
                    this.getFlightOffers();
                })
                .catch(error => {
                    this.error = error.message;
                });
        },
        getFlightOffers() {
            const url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
            const params = {
                originLocationCode: this.originLocationCode,
                destinationLocationCode: this.destinationLocationCode,
                departureDate: this.departureDate,
                returnDate: this.returnDate,
                adults: this.adults,
                max: this.max,
                currencyCode: this.currencyCode,
            };

            axios
                .get(url, {
                    headers: {
                        Authorization: `Bearer ${this.accessToken}`,
                    },
                    params: params,
                })
                .then((response) => {
                    this.flightOffers = response.data;

                })
                .catch((error) => {
                    this.error = error.message;
                });
        },
        getCityName(iataCode) {
            return this.locations[iataCode]?.cityCode || iataCode;
        },
        formatDate(date) {
            const formattedDate = new Date(date);
            return formattedDate.toLocaleDateString();
        }
    },
};
</script>
<style>

</style>
